<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PartnersController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $iconPath = 'admin-assets/partners/icon/';

    /**
     * Partners list page.
     */
    public function index()
    {
        return view('admin.partners.index');
    }

    /**
     * DataTable ajax feed for the partners list.
     */
    public function getPartnersData()
    {
        $partners = Partner::select('partners.*');

        return DataTables::of($partners)
            ->addIndexColumn()
            ->addColumn('icon', function ($row) {
                if (! $row->icon) {
                    return '-';
                }
                $url = asset($this->iconPath . $row->icon);
                return '<img src="' . $url . '" alt="' . e($row->icon_alt) . '" style="max-width:60px;max-height:60px;">';
            })
            ->addColumn('status', function ($row) {
                $badge = $row->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('partners.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-partner" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['icon', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add partner form.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a new partner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['icon'] = $this->uploadImage($request, 'icon', $this->iconPath);

        Partner::create($validated);

        return redirect()->route('partners.index')->with('toast_success', 'Partner created successfully.');
    }

    /**
     * Show edit partner form.
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update an existing partner.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate($this->rules($partner));

        if ($request->hasFile('icon')) {
            $this->deleteImage($partner->icon);
            $validated['icon'] = $this->uploadImage($request, 'icon', $this->iconPath);
        } else {
            unset($validated['icon']);
        }

        $partner->update($validated);

        return redirect()->route('partners.index')->with('toast_success', 'Partner updated successfully.');
    }

    /**
     * Delete a partner and its icon (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        $this->deleteImage($partner->icon);

        $partner->delete();

        return response()->json(['success' => true, 'message' => 'Partner deleted successfully.']);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(?Partner $partner = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp,svg|max:2048';

        return [
            'icon'     => ($partner ? 'nullable|' : 'required|') . $image,
            'icon_alt' => 'required|string|max:255',
            'status'   => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Upload a file to the given public path and return the stored filename.
     */
    protected function uploadImage(Request $request, string $field, string $path): ?string
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
     * Delete a previously uploaded image file, if it exists.
     */
    protected function deleteImage(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $fullPath = public_path($this->iconPath . $fileName);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
