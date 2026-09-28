<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogsController extends Controller
{
    protected string $frontImagePath  = 'public/admin-assets/blogs/front_image/';
    protected string $detailImagePath = 'public/admin-assets/blogs/detail_image/';
    protected string $ctaImagePath    = 'public/admin-assets/blogs/cta_image/';

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
                $badge = $row->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('blogs.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="icofont-edit"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-blog" data-id="' . $row->id . '"><i class="icofont-ui-delete"></i> Delete</button>
                ';
            })
            ->rawColumns(['front_image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add blog form.
     */
    public function createBlogs()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a new blog.
     */
    public function BlogsStore(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'url'                 => 'required|string|max:255|unique:blogs,url',
            'front_image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'front_image_alt'     => 'required|string|max:255',
            'detail_image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'detail_image_alt'    => 'required|string|max:255',
            'cta_image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cta_image_alt'       => 'nullable|string|max:255',
            'cta_link_url'        => 'nullable|string|max:255',
            'date'                => 'nullable|date',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'short_description'   => 'required|string',
            'detail_description'  => 'nullable|string',
            'conclusion'          => 'nullable|string',
            'schema_json'         => 'nullable|string',
            'status'              => 'required|in:Active,In-Active',
            'faq_title.*'         => 'nullable|string|max:255',
            'question.*'          => 'nullable|string|max:255',
            'answer.*'            => 'nullable|string',
        ]);

        $validated['front_image']  = $this->uploadImage($request, 'front_image', $this->frontImagePath);
        $validated['detail_image'] = $this->uploadImage($request, 'detail_image', $this->detailImagePath);
        $validated['cta_image']    = $this->uploadImage($request, 'cta_image', $this->ctaImagePath);
        $validated['faqs']         = $this->buildFaqsArray($request);

        Blog::create($validated);

        return redirect()->route('blogs')->with('success', 'Blog added successfully.');
    }

    /**
     * Show edit blog form.
     */
    public function EditBlogs($id)
    {
        $blogs = Blog::findOrFail($id);

        return view('admin.blogs.edit', compact('blogs'));
    }

    /**
     * Update an existing blog.
     */
    public function UpdateBlogs(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'url'                 => 'required|string|max:255|unique:blogs,url,' . $blog->id,
            'front_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'front_image_alt'     => 'required|string|max:255',
            'detail_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'detail_image_alt'    => 'required|string|max:255',
            'cta_image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cta_image_alt'       => 'nullable|string|max:255',
            'cta_link_url'        => 'nullable|string|max:255',
            'date'                => 'nullable|date',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'short_description'   => 'required|string',
            'detail_description'  => 'nullable|string',
            'conclusion'          => 'nullable|string',
            'schema_json'         => 'nullable|string',
            'status'              => 'required|in:Active,In-Active',
            'faq_title.*'         => 'nullable|string|max:255',
            'question.*'          => 'nullable|string|max:255',
            'answer.*'            => 'nullable|string',
        ]);

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
        }

        $validated['faqs'] = $this->buildFaqsArray($request);

        $blog->update($validated);

        return redirect()->route('blogs')->with('success', 'Blog updated successfully.');
    }

    /**
     * Delete a blog, its images and its FAQs.
     */
    public function DestoryBlogs($id)
    {
        $blog = Blog::findOrFail($id);

        $this->deleteImage($this->frontImagePath, $blog->front_image);
        $this->deleteImage($this->detailImagePath, $blog->detail_image);
        $this->deleteImage($this->ctaImagePath, $blog->cta_image);

        $blog->delete();

        return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
    }

    /**
     * Build the FAQs array (to be cast to JSON and saved directly on the
     * blogs.faqs column) from the submitted faq_title[] / question[] / answer[]
     * parallel arrays.
     */
    protected function buildFaqsArray(Request $request): array
    {
        $titles    = $request->input('faq_title', []);
        $questions = $request->input('question', []);
        $answers   = $request->input('answer', []);

        $rowCount = max(count($titles), count($questions), count($answers));
        $faqs     = [];

        for ($index = 0; $index < $rowCount; $index++) {
            $title    = $titles[$index]    ?? null;
            $question = $questions[$index] ?? null;
            $answer   = $answers[$index]   ?? null;

            if (blank($title) && blank($question) && blank($answer)) {
                continue;
            }

            $faqs[] = [
                'faq_title' => $title,
                'question'  => $question,
                'answer'    => $answer,
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

        $file->move(public_path(str_replace('public/', '', $path)), $fileName);

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

        $fullPath = public_path(str_replace('public/', '', $path)) . '/' . $fileName;

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
