<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Banner, Blog, Category, Event, Locator, OurBrand, Partner, Product, TechnicalDataSheet};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TrashController extends Controller
{
    private array $modules = [
        'banners' => [Banner::class, 'Banners', 'banners.index', [['image', 'admin-assets/banners/image/']]],
        'blogs' => [Blog::class, 'Blogs', 'blogs.index', [
            ['front_image', 'admin-assets/blogs/front_image/'],
            ['detail_image', 'admin-assets/blogs/detail_image/'],
            ['cta_image', 'admin-assets/blogs/cta_image/'],
        ]],
        'categories' => [Category::class, 'Categories', 'categories.index', [['thumbnail', 'admin-assets/categories/thumbnail/']]],
        'events' => [Event::class, 'Events', 'events.index', [['image', 'admin-assets/events/image/']]],
        'locators' => [Locator::class, 'Locators', 'locators.index', []],
        'our-brands' => [OurBrand::class, 'Our Brands', 'our-brands.index', [['icon', 'admin-assets/our-brands/icon/']]],
        'partners' => [Partner::class, 'Partners', 'partners.index', [['icon', 'admin-assets/partners/icon/']]],
        'products' => [Product::class, 'Products', 'products.index', [
            ['image', 'admin-assets/products/image/'],
            ['catalogue', 'admin-assets/products/catalogue/'],
        ]],
        'technical-data-sheets' => [TechnicalDataSheet::class, 'Technical Data Sheets', 'technical-data-sheets.index', [
            ['brochure', 'admin-assets/technical-data-sheets/brochure/'],
            ['pdf', 'admin-assets/technical-data-sheets/pdf/'],
        ]],
    ];

    public function index(Request $request, string $module)
    {
        abort_unless(isset($this->modules[$module]), 404);
        [$model, $label] = $this->modules[$module];
        $records = $model::onlyTrashed()->latest('deleted_at')->paginate(15)->withQueryString();

        return view('admin.trash.index', compact('module', 'label', 'records'));
    }

    public function restore(string $module, int $id)
    {
        abort_unless(isset($this->modules[$module]), 404);
        [$model] = $this->modules[$module];
        $model::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.trash.index', $module)->with('toast_success', 'Record restored successfully.');
    }

    public function forceDelete(string $module, int $id)
    {
        abort_unless(isset($this->modules[$module]), 404);
        [$model, , , $files] = $this->modules[$module];
        $record = $model::onlyTrashed()->findOrFail($id);

        foreach ($files as [$field, $directory]) {
            if ($record->{$field}) {
                $path = public_path($directory . $record->{$field});
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }

        $record->forceDelete();

        return redirect()->route('admin.trash.index', $module)->with('toast_success', 'Record permanently deleted.');
    }
}
