<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OurBrandsController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $iconPath = 'admin-assets/our-brands/icon/';

    /**
     * Brands list page.
     */
    public function index()
    {
        return view('admin.our-brands.index');
    }

    /**
     * DataTable ajax feed for the brands list.
     */
    public function getOurBrandsData()
    {
        $brands = OurBrand::select('our_brands.*');

        return DataTables::of($brands)
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
                $editUrl = route('our-brands.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-brand" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['icon', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add brand form.
     */
    public function create()
    {
        return view('admin.our-brands.create');
    }

    /**
     * Store a new brand.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['icon'] = $this->uploadImage($request, 'icon', $this->iconPath);

        OurBrand::create($validated);

        return redirect()->route('our-brands.index')->with('toast_success', 'Brand created successfully.');
    }

    /**
     * Show edit brand form.
     */
    public function edit($id)
    {
        $ourBrands = OurBrand::findOrFail($id);

        return view('admin.our-brands.edit', compact('ourBrands'));
    }

    /**
     * Update an existing brand.
     */
    public function update(Request $request, $id)
    {
        $brand = OurBrand::findOrFail($id);

        $validated = $request->validate($this->rules($brand));

        if ($request->hasFile('icon')) {
            $this->deleteImage($brand->icon);
            $validated['icon'] = $this->uploadImage($request, 'icon', $this->iconPath);
        }

        $brand->update($validated);

        return redirect()->route('our-brands.index')->with('toast_success', 'Brand updated successfully.');
    }

    /**
     * Delete a brand and its icon (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $brand = OurBrand::findOrFail($id);

        $this->deleteImage($brand->icon);

        $brand->delete();

        return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(?OurBrand $brand = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp,svg|max:2048';

        return [
            'icon'     => ($brand ? 'nullable|' : 'required|') . $image,
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