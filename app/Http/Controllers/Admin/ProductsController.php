<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    // Upload folders (relative to the /public directory)
    protected string $imagePath     = 'admin-assets/products/image/';
    protected string $cataloguePath = 'admin-assets/products/catalogue/';

    /**
     * Products list page.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    
    public function getProductsData()
    {
        $products = Product::with('category')->select('products.*');

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if (! $row->image) {
                    return '-';
                }
                $url = asset($this->imagePath . $row->image);
                return '<img src="' . $url . '" alt="' . e($row->image_alt) . '" style="max-width:80px;max-height:60px;">';
            })
            ->addColumn('category', fn ($row) => e($row->category->title ?? '-'))
            ->editColumn('title', fn ($row) => e($row->title))
            ->editColumn('name', fn ($row) => e($row->name))
            ->editColumn('sort_order', function ($row) {
    return '<input type="number" min="0" max="99999"
                class="form-control form-control-sm sort-input"
                style="width:90px"
                data-id="' . $row->id . '"
                data-old="' . (int) $row->sort_order . '"
                value="' . (int) $row->sort_order . '">';
})
->order(function ($query) {
    $sort = request('sort_filter');
    if (in_array($sort, ['asc', 'desc'])) {
        $query->orderBy('sort_order', $sort)->orderBy('id', 'desc');
    } else {
        $query->orderBy('id', 'desc');   // All (Default) = newest first
    }
})
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('products.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-product" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['image','sort_order', 'status', 'action'])
            ->make(true);
    }

    
    public function create()
    {
        $categories = $this->categoryOptions();

        return view('admin.products.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        unset($validated['remove_catalogue']);

        $tempCatalogue = $validated['catalogue_temp'] ?? null;
        unset($validated['catalogue_temp']);

        if (empty($validated['product_url'])) {
            $validated['product_url'] = Str::slug($validated['name']);

            if ($message = $this->urlConflictMessage($validated['product_url'], 'products')) {
                return back()->withInput()->withErrors(['product_url' => $message]);
            }
        }

        $validated['image']     = $this->uploadFile($request, 'image', $this->imagePath);
        $validated['catalogue'] = $request->hasFile('catalogue')
            ? $this->uploadFile($request, 'catalogue', $this->cataloguePath)
            : $this->takeTempCatalogue($tempCatalogue);
       $validated['sort_order'] = $validated['sort_order'] ?? 9999;
        Product::create($validated);

        return redirect()->route('products.index')->with('toast_success', 'Product created successfully.');
    }

   
    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = $this->categoryOptions($product);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate($this->rules($product));

        $tempCatalogue = $validated['catalogue_temp'] ?? null;
        unset($validated['catalogue_temp']);

        if (empty($validated['product_url'])) {
            $validated['product_url'] = Str::slug($validated['name']);

            if ($message = $this->urlConflictMessage($validated['product_url'], 'products', $product->id)) {
                return back()->withInput()->withErrors(['product_url' => $message]);
            }
        }

        if ($request->hasFile('image')) {
            $this->deleteFile($product->image, $this->imagePath);
            $validated['image'] = $this->uploadFile($request, 'image', $this->imagePath);
        } else {
            unset($validated['image']);
        }

        if ($request->hasFile('catalogue')) {
            $this->deleteFile($product->catalogue, $this->cataloguePath);
            $validated['catalogue'] = $this->uploadFile($request, 'catalogue', $this->cataloguePath);
        } elseif ($tempCatalogue && ($newCatalogue = $this->takeTempCatalogue($tempCatalogue))) {
            $this->deleteFile($product->catalogue, $this->cataloguePath);
            $validated['catalogue'] = $newCatalogue;
        } elseif ($request->input('remove_catalogue') == '1') {
            $this->deleteFile($product->catalogue, $this->cataloguePath);
            $validated['catalogue'] = null;
        } else {
            unset($validated['catalogue']);
        }

        unset($validated['remove_catalogue']);
        $validated['sort_order'] = $validated['sort_order'] ?? 9999;
        $product->update($validated);

        return redirect()->route('products.index')->with('toast_success', 'Product updated successfully.');
    }

    /**
     * Delete a product with its image + catalogue (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    
    public function uploadCatalogue(Request $request)
    {
        $request->validate([
            'catalogue' => 'required|file|mimes:pdf|max:2097152', // 2 GB (KB me)
        ]);

        $dir = $this->tempCataloguePath();
        File::ensureDirectoryExists($dir);

        // 1 din se purani adhuri temp files saaf karo
        $limit = now()->subDay()->getTimestamp();
        foreach (File::files($dir) as $old) {
            if ($old->getMTime() < $limit) {
                File::delete($old->getPathname());
            }
        }

        $file = $request->file('catalogue');
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'catalogue';
        $name = $base . '_' . time() . '_' . Str::random(6) . '.pdf';

        $file->move($dir, $name);

        return response()->json([
            'success' => true,
            'temp'    => $name,
        ]);
    }

    
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status = $product->status === 'Active' ? 'In-Active' : 'Active';
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $product->status,
        ]);
    }

    
    protected function rules(?Product $product = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($product) {
                    // only Active categories (plus the one already saved on this product)
                    $query->where(function ($q) use ($product) {
                        $q->where('status', 'Active');

                        if ($product?->category_id) {
                            $q->orWhere('id', $product->category_id);
                        }
                    });
                }),
            ],
            'title'             => 'required|string|max:255',
            'name'              => 'required|string|max:255',
            'product_url'       => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($product) {
                    if ($value && ($message = $this->urlConflictMessage($value, 'products', $product?->id))) {
                        $fail($message);
                    }
                },
            ],
            'image'             => ($product ? 'nullable|' : 'required|') . $image,
            'image_alt'         => 'required|string|max:255',
            'description'       => 'required|string',
            'catalogue'         => 'nullable|file|mimes:pdf|max:2097152', // 2 GB (KB me)
            'remove_catalogue'  => 'nullable|in:0,1',
            'catalogue_temp'    => ['nullable', 'string', 'regex:/^[a-z0-9\-]+_\d+_[A-Za-z0-9]{6}\.pdf$/'],
            'technical_details' => 'nullable|string',
            'status'            => 'required|in:Active,In-Active',
            'sort_order' => 'nullable|integer|min:0|max:99999',
        ];
    }

    protected function urlConflictMessage(string $value, string $currentTable, ?int $currentId = null): ?string
    {
        $sources = [
            'blogs'      => ['column' => 'url',          'label' => 'blog'],
            'categories' => ['column' => 'category_url', 'label' => 'category'],
            'products'   => ['column' => 'product_url',  'label' => 'product'],
        ];

        foreach ($sources as $table => $source) {
            $query = DB::table($table)->where($source['column'], $value);

            if ($table === $currentTable && $currentId) {
                $query->where('id', '!=', $currentId);
            }

            if ($query->exists()) {
                return $table === $currentTable
                    ? 'This URL is already used by another ' . $source['label'] . '.'
                    : 'This URL is already used by a ' . $source['label'] . '.';
            }
        }

        return null;
    }

    /**
     * Categories for the dropdown: all Active ones, plus the product's current
     * category (so an In-Active one still shows while editing).
     */
    protected function categoryOptions(?Product $product = null)
    {
        return Category::where('status', 'Active')
            ->when($product?->category_id, fn ($q) => $q->orWhere('id', $product->category_id))
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    /**
     * Temp upload folder (public nahi hai, sirf server ke andar).
     */
    protected function tempCataloguePath(): string
    {
        return storage_path('app/tmp-catalogue');
    }

    /**
     * Temp me upload hui PDF ko final catalogue folder me le jao.
     * Final filename return karta hai, file na mile to null.
     */
    protected function takeTempCatalogue(?string $temp): ?string
    {
        if (! $temp) {
            return null;
        }

        $src = $this->tempCataloguePath() . DIRECTORY_SEPARATOR . $temp;

        if (! File::exists($src)) {
            return null;
        }

        File::ensureDirectoryExists(public_path($this->cataloguePath));
        $dst = public_path($this->cataloguePath . $temp);

        if (! @rename($src, $dst)) {
            File::copy($src, $dst);
            File::delete($src);
        }

        return $temp;
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
    public function updateSort(Request $request, $id)
{
    $request->validate(['sort_order' => 'required|integer|min:0|max:99999']);

    $product = Product::findOrFail($id);
    $product->sort_order = $request->sort_order;
    $product->save();

    return response()->json(['success' => true, 'message' => 'Sort order updated successfully.']);
}
}
