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
    // Upload folders (relative to the /public directory)
    protected string $brochurePath = 'admin-assets/technical-data-sheets/brochure/';
    protected string $pdfPath      = 'admin-assets/technical-data-sheets/pdf/';

    /**
     * Technical data sheets list page.
     */
    public function index()
    {
        return view('admin.technical-data-sheets.index');
    }

    /**
     * DataTable ajax feed for the list.
     */
    public function getTechnicalDataSheetsData()
    {
        $sheets = TechnicalDataSheet::with('category')->select('technical_data_sheets.*');

        return DataTables::of($sheets)
            ->addIndexColumn()
            ->addColumn('category', fn ($row) => e($row->category->title ?? '-'))
            ->addColumn('brochure', fn ($row) => $this->fileLink($row->brochure, $this->brochurePath))
            ->addColumn('pdf', fn ($row) => $this->fileLink($row->pdf, $this->pdfPath))
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
            ->rawColumns(['brochure', 'pdf', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add form.
     */
    public function create()
    {
        $categories = $this->categoryOptions();

        return view('admin.technical-data-sheets.create', compact('categories'));
    }

    /**
     * Store a new technical data sheet.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['brochure'] = $this->uploadFile($request, 'brochure', $this->brochurePath);
        $validated['pdf']      = $this->uploadFile($request, 'pdf', $this->pdfPath);

        TechnicalDataSheet::create($validated);

        return redirect()->route('technical-data-sheets.index')->with('toast_success', 'Technical data sheet created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $sheet      = TechnicalDataSheet::findOrFail($id);
        $categories = $this->categoryOptions($sheet);

        return view('admin.technical-data-sheets.edit', compact('sheet', 'categories'));
    }

    /**
     * Update an existing technical data sheet.
     */
    public function update(Request $request, $id)
    {
        $sheet = TechnicalDataSheet::findOrFail($id);

        $validated = $request->validate($this->rules($sheet));

        foreach ([['brochure', $this->brochurePath], ['pdf', $this->pdfPath]] as [$field, $path]) {
            if ($request->hasFile($field)) {
                $this->deleteFile($sheet->{$field}, $path);
                $validated[$field] = $this->uploadFile($request, $field, $path);
            } else {
                unset($validated[$field]);
            }
        }

        $sheet->update($validated);

        return redirect()->route('technical-data-sheets.index')->with('toast_success', 'Technical data sheet updated successfully.');
    }

    /**
     * Delete a record with its files (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $sheet = TechnicalDataSheet::findOrFail($id);

        $this->deleteFile($sheet->brochure, $this->brochurePath);
        $this->deleteFile($sheet->pdf, $this->pdfPath);

        $sheet->delete();

        return response()->json(['success' => true, 'message' => 'Technical data sheet deleted successfully.']);
    }

    /**
     * Switch Active / In-Active from the list page (ajax).
     */
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

    /**
     * Server-side validation rules.
     */
    protected function rules(?TechnicalDataSheet $sheet = null): array
    {
        $pdf = 'file|mimes:pdf|max:10240';
        $req = $sheet ? 'nullable|' : 'required|';

        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($sheet) {
                    // only Active categories (plus the one already saved on this record)
                    $query->where(function ($q) use ($sheet) {
                        $q->where('status', 'Active');

                        if ($sheet?->category_id) {
                            $q->orWhere('id', $sheet->category_id);
                        }
                    });
                }),
            ],
            'brochure' => $req . $pdf,
            'pdf'      => $req . $pdf,
            'status'   => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Categories for the dropdown: all Active ones, plus the record's current
     * category (so an In-Active one still shows while editing).
     */
    protected function categoryOptions(?TechnicalDataSheet $sheet = null)
    {
        return Category::where('status', 'Active')
            ->when($sheet?->category_id, fn ($q) => $q->orWhere('id', $sheet->category_id))
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    /**
     * "View" link for the list page.
     */
    protected function fileLink(?string $fileName, string $path): string
    {
        if (! $fileName) {
            return '-';
        }

        return '<a href="' . asset($path . $fileName) . '" target="_blank"><i class="bi bi-file-earmark-pdf"></i> View</a>';
    }

    /**
     * Upload a file to the given public path and return the stored filename.
     */
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

    /**
     * Delete a previously uploaded file, if it exists.
     */
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
