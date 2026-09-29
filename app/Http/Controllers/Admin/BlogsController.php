<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{
    // Upload folders (relative to the /public directory)
    protected string $frontImagePath  = 'admin-assets/blogs/front_image/';
    protected string $detailImagePath = 'admin-assets/blogs/detail_image/';
    protected string $ctaImagePath    = 'admin-assets/blogs/cta_image/';

    /**
     * Blogs list page.
     */
    public function index()
    {
        return view('admin.blogs.index');
    }

    /**
     * DataTable ajax feed for the blogs list.
     */
    public function getBlogsData()
    {
        $blogs = Blog::select('blogs.*');

        return DataTables::of($blogs)
            ->addIndexColumn()
            ->addColumn('front_image', function ($row) {
                if (! $row->front_image) {
                    return '-';
                }
                $url = asset($this->frontImagePath . $row->front_image);
                return '<img src="' . $url . '" alt="' . e($row->front_image_alt) . '" style="max-width:60px;max-height:60px;">';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
    return '<div class="form-check form-switch">
                <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
            </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('blogs.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-blog" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['front_image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add blog form.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a new blog.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        // Build FAQs first: it can throw a validation error before any file is saved
        $validated['faqs'] = $this->buildFaqsArray($request);

        $validated['front_image']  = $this->uploadImage($request, 'front_image', $this->frontImagePath);
        $validated['detail_image'] = $this->uploadImage($request, 'detail_image', $this->detailImagePath);
        $validated['cta_image']    = $this->uploadImage($request, 'cta_image', $this->ctaImagePath);

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('toast_success', 'Blog created successfully.');
    }

    /**
     * Show edit blog form.
     */
    public function edit($id)
    {
        $blogs = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blogs'));
    }

    /**
     * Update an existing blog.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate($this->rules($blog));

        $validated['faqs'] = $this->buildFaqsArray($request);

        if ($request->hasFile('front_image')) {
            $this->deleteImage($this->frontImagePath, $blog->front_image);
            $validated['front_image'] = $this->uploadImage($request, 'front_image', $this->frontImagePath);
        }

        if ($request->hasFile('detail_image')) {
            $this->deleteImage($this->detailImagePath, $blog->detail_image);
            $validated['detail_image'] = $this->uploadImage($request, 'detail_image', $this->detailImagePath);
        }

        if ($request->hasFile('cta_image')) {
            $this->deleteImage($this->ctaImagePath, $blog->cta_image);
            $validated['cta_image'] = $this->uploadImage($request, 'cta_image', $this->ctaImagePath);
        } elseif ($request->boolean('remove_cta_image')) {
            $this->deleteImage($this->ctaImagePath, $blog->cta_image);
            $validated['cta_image'] = null;
            $validated['cta_image_alt'] = null;
        }

        $blog->update($validated);

        return redirect()->route('blogs.index')->with('toast_success', 'Blog updated successfully.');
    }

    /**
     * Delete a blog and its images (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        $this->deleteImage($this->frontImagePath, $blog->front_image);
        $this->deleteImage($this->detailImagePath, $blog->detail_image);
        $this->deleteImage($this->ctaImagePath, $blog->cta_image);

        $blog->delete();

        return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
    }

    /**
 * Switch Active / In-Active from the list page (ajax).
 */
public function toggleStatus($id)
{
    $blog = Blog::findOrFail($id);

    $blog->status = $blog->status === 'Active' ? 'In-Active' : 'Active';
    $blog->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'status'  => $blog->status,
    ]);
}

    /**
     * Server-side validation rules (keep in sync with blogs/_scripts.blade.php).
     */
    protected function rules(?Blog $blog = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'title'              => 'required|string|max:255',
            'url'                => 'required|string|max:255|unique:blogs,url' . ($blog ? ',' . $blog->id : ''),
            'front_image'        => ($blog ? 'nullable|' : 'required|') . $image,
            'front_image_alt'    => 'required|string|max:255',
            'detail_image'       => ($blog ? 'nullable|' : 'required|') . $image,
            'detail_image_alt'   => 'required|string|max:255',
            'cta_image'          => 'nullable|' . $image,
            'cta_image_alt'      => 'nullable|string|max:255',
            'cta_link_url'       => 'nullable|string|max:255',
            'date'               => 'nullable|date',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'short_description'  => 'required|string',
            'detail_description' => 'nullable|string',
            'conclusion'         => 'nullable|string',
            'schema_json'        => 'nullable|string',
            'status'             => 'required|in:Active,In-Active',
            'faq_title.*'        => 'nullable|string|max:255',
            'faq_description.*'  => 'nullable|string',
        ];
    }

    /**
     * Build the FAQs array (cast to JSON on the blogs.faqs column) from the
     * submitted faq_title[] / faq_description[] parallel arrays.
     * Rows where both fields are empty are skipped; a half-filled row is an error.
     */
    protected function buildFaqsArray(Request $request): array
    {
        $titles       = $request->input('faq_title', []);
        $descriptions = $request->input('faq_description', []);

        $rowCount = max(count($titles), count($descriptions));
        $faqs     = [];

        for ($index = 0; $index < $rowCount; $index++) {
            $title       = trim((string) ($titles[$index] ?? ''));
            $description = (string) ($descriptions[$index] ?? '');
            $descText    = trim(strip_tags(str_replace('&nbsp;', ' ', $description)));

            if ($title === '' && $descText === '') {
                continue;
            }

            if ($title === '' || $descText === '') {
                throw ValidationException::withMessages([
                    'faq_title' => 'Each FAQ needs both a title and a description.',
                ]);
            }

            $faqs[] = [
                'faq_title'       => $title,
                'faq_description' => $description,
            ];
        }

        return $faqs;
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
    protected function deleteImage(string $path, ?string $fileName): void
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
