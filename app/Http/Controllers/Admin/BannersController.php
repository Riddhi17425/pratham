<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BannersController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $imagePath = 'admin-assets/banners/image/';

    /**
     * Banners list page.
     */
    public function index()
    {
        return view('admin.banners.index');
    }

    /**
     * DataTable ajax feed for the banners list.
     */
    public function getBannersData()
    {
        $banners = Banner::select('banners.*');

        return DataTables::of($banners)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if (! $row->image) {
                    return '-';
                }
                $url = asset($this->imagePath . $row->image);
                return '<img src="' . $url . '" alt="' . e($row->image_alt) . '" style="max-width:80px;max-height:60px;">';
            })
            ->editColumn('title', function ($row) {
                return e($row->title);
            })
            ->addColumn('description', function ($row) {
                return e(Str::limit(strip_tags($row->description), 80));
            })
            ->addColumn('status', function ($row) {
                $badge = $row->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('banners.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-banner" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add banner form.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a new banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['image'] = $this->uploadImage($request, 'image', $this->imagePath);

        Banner::create($validated);

        return redirect()->route('banners.index')->with('toast_success', 'Banner created successfully.');
    }

    /**
     * Show edit banner form.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update an existing banner.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate($this->rules($banner));

        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image);
            $validated['image'] = $this->uploadImage($request, 'image', $this->imagePath);
        } else {
            unset($validated['image']);
        }

        $banner->update($validated);

        return redirect()->route('banners.index')->with('toast_success', 'Banner updated successfully.');
    }

    /**
     * Delete a banner and its image (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $this->deleteImage($banner->image);

        $banner->delete();

        return response()->json(['success' => true, 'message' => 'Banner deleted successfully.']);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(?Banner $banner = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => ($banner ? 'nullable|' : 'required|') . $image,
            'image_alt'   => 'required|string|max:255',
            'status'      => 'required|in:Active,In-Active',
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

        $fullPath = public_path($this->imagePath . $fileName);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
