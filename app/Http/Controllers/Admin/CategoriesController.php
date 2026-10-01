<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $thumbnailPath = 'admin-assets/categories/thumbnail/';

    /**
     * Categories list page.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * DataTable ajax feed for the categories list.
     */
    public function getCategoriesData()
    {
        $categories = Category::select('categories.*');

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                if (! $row->thumbnail) {
                    return '-';
                }
                $url = asset($this->thumbnailPath . $row->thumbnail);
                return '<img src="' . $url . '" alt="' . e($row->thumbnail_alt) . '" style="max-width:80px;max-height:60px;">';
            })
            ->editColumn('title', fn ($row) => e($row->title))
            ->editColumn('category_url', fn ($row) => e($row->category_url))
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('categories.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-category" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['thumbnail', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add category form.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $validated['thumbnail'] = $this->uploadImage($request, 'thumbnail', $this->thumbnailPath);

        Category::create($validated);

        return redirect()->route('categories.index')->with('toast_success', 'Category created successfully.');
    }

    /**
     * Show edit category form.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate($this->rules($category), $this->messages());

        if ($request->hasFile('thumbnail')) {
            $this->deleteImage($category->thumbnail, $this->thumbnailPath);
            $validated['thumbnail'] = $this->uploadImage($request, 'thumbnail', $this->thumbnailPath);
        } else {
            unset($validated['thumbnail']);
        }

        $category->update($validated);

        return redirect()->route('categories.index')->with('toast_success', 'Category updated successfully.');
    }

    /**
     * Delete a category and its thumbnail (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    /**
     * Switch Active / In-Active from the list page (ajax).
     */
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        $category->status = $category->status === 'Active' ? 'In-Active' : 'Active';
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $category->status,
        ]);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(?Category $category = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'title'            => 'required|string|max:255',
            'category_url'     => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('categories', 'category_url')->ignore($category?->id),
            ],
            'description'      => 'nullable|string',
            'meta_title'       => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'thumbnail'        => ($category ? 'nullable|' : 'required|') . $image,
            'thumbnail_alt'    => 'required|string|max:255',
            'status'           => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Custom validation messages.
     */
    protected function messages(): array
    {
        return [
            'category_url.regex'  => 'Use only lowercase letters, numbers and hyphens (e.g. web-design).',
            'category_url.unique' => 'This category URL is already taken.',
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
    protected function deleteImage(?string $fileName, string $path): void
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
