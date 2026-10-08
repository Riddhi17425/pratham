<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TechnicalDataSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TechnicalDataSheetsController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $brochurePath = 'admin-assets/technical-data-sheets/brochure/';

    public function index()
    {
        return view('admin.technical-data-sheets.index');
    }

    public function getTechnicalDataSheetsData()
    {
        $sheets = TechnicalDataSheet::with('category')->select('technical_data_sheets.*');

        return DataTables::of($sheets)
            ->addIndexColumn()
            ->addColumn('category', fn ($row) => e($row->category->title ?? '-'))
            ->addColumn('brochure', fn ($row) => $this->fileLink($row->brochure, $this->brochurePath))
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('technical-data-sheets.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-sheet" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['brochure', 'status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $categories = $this->categoryOptions();

        return view('admin.technical-data-sheets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        unset($validated['remove_brochure']);

        $validated['brochure'] = $this->uploadFile($request, 'brochure', $this->brochurePath);

        TechnicalDataSheet::create($validated);

        return redirect()->route('technical-data-sheets.index')->with('toast_success', 'Technical data sheet created successfully.');
    }

    public function edit($id)
    {
        $sheet      = TechnicalDataSheet::findOrFail($id);
        $categories = $this->categoryOptions($sheet);

        return view('admin.technical-data-sheets.edit', compact('sheet', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $sheet = TechnicalDataSheet::findOrFail($id);

        $validated = $request->validate($this->rules($sheet), $this->messages());
        unset($validated['remove_brochure']); // only a UI flag, not a DB column

        if ($request->hasFile('brochure')) {
            $this->deleteFile($sheet->brochure, $this->brochurePath);
            $validated['brochure'] = $this->uploadFile($request, 'brochure', $this->brochurePath);
        } else {
            unset($validated['brochure']);
        }

        $sheet->update($validated);

        return redirect()->route('technical-data-sheets.index')->with('toast_success', 'Technical data sheet updated successfully.');
    }

    public function destroy($id)
    {
        $sheet = TechnicalDataSheet::findOrFail($id);

        // Merge conflict resolved: file delete line removed because the module
        // has a Trash (soft delete) feature, so the file must stay for restore.
        // If you do NOT use soft delete, add this line back:
        // $this->deleteFile($sheet->brochure, $this->brochurePath);
        $sheet->delete();

        return response()->json(['success' => true, 'message' => 'Technical data sheet deleted successfully.']);
    }

    public function toggleStatus($id)
    {
        $sheet = TechnicalDataSheet::findOrFail($id);

        $sheet->status = $sheet->status === 'Active' ? 'In-Active' : 'Active';
        $sheet->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $sheet->status,
        ]);
    }

    protected function rules(?TechnicalDataSheet $sheet = null): array
    {
        // Edit page: optional, unless the user removed the current file (then a new one is required)
        $isOptional = $sheet && ! request()->boolean('remove_brochure');

        // 2 MB = 2048 KB (Laravel `max` KB me hota hai)
        $brochure = ($isOptional ? 'nullable' : 'required') . '|file|mimes:pdf|mimetypes:application/pdf|max:2048';

        return [
            'remove_brochure' => 'nullable|boolean',
            // Category is optional
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(function ($query) use ($sheet) {
                    $query->where(function ($q) use ($sheet) {
                        $q->where('status', 'Active');

                        if ($sheet?->category_id) {
                            $q->orWhere('id', $sheet->category_id);
                        }
                    });
                }),
            ],
            'brochure' => $brochure,
            'status'   => 'required|in:Active,In-Active',
        ];
    }

    protected function messages(): array
    {
        return [
            'brochure.required'  => 'Please select the brochure PDF.',
            'brochure.max'       => 'The brochure may not be greater than 2 MB.',
            'brochure.mimes'     => 'Only PDF files are allowed.',
            'brochure.mimetypes' => 'Only PDF files are allowed.',
            'brochure.uploaded'  => 'The brochure failed to upload. Please make sure it is a PDF of max 2 MB.',
        ];
    }

    protected function categoryOptions(?TechnicalDataSheet $sheet = null)
    {
        return Category::where('status', 'Active')
            ->when($sheet?->category_id, fn ($q) => $q->orWhere('id', $sheet->category_id))
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    protected function fileLink(?string $fileName, string $path): string
    {
        if (! $fileName) {
            return '-';
        }

        return '<a href="' . asset($path . $fileName) . '" target="_blank"><i class="bi bi-file-earmark-pdf"></i> View</a>';
    }

    protected function uploadFile(Request $request, string $field, string $path): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file     = $request->file($field);
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path($path), $fileName);

        return $fileName;
    }

    protected function deleteFile(?string $fileName, string $path): void
    {
        if (! $fileName) {
            return;
        }

        $fullPath = public_path($path . $fileName);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
