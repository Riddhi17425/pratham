<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Event;
use App\Models\OurBrand;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Locator;
use App\Models\Setting;
use App\Models\TechnicalDataSheet;

class FrontController extends Controller
{
    public function home(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';

        // category_id NULL            => "All Categories" banner (always shown)
        // category_id has a value     => show only if that category is Active and not deleted
        $banners = Banner::with('category')
            ->where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('category_id')
                  ->orWhereHas('category', fn ($c) => $c->where('status', 'Active'));
            })
            ->latest()
            ->get();

        $partners = Partner::where('status', 'Active')->latest()->get();
        $brands = OurBrand::where('status', 'Active')->latest()->get();
        $blogs = Blog::where('status', 'Active')->orderByDesc('created_at')->take(4)->get();

        return view('front.home', compact('metaTitle', 'metaDescription', 'banners', 'partners', 'brands', 'blogs'));
    }

    public function about(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $brands = OurBrand::where('status', 'Active')->latest()->get();
        return view('front.about', compact('metaTitle', 'metaDescription', 'brands'));
    }

    public function getBlogs(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $blogs = Blog::where('status', 'Active')->orderByDesc('created_at')->get();
        return view('front.blogs', compact('metaTitle', 'metaDescription', 'blogs'));
    }

    public function blogDetails(Request $requesr){
        $blog = Blog::where('url', $requesr->query('post'))
            ->firstOrFail();
        $metaTitle = $blog->meta_title ?: $blog->title;
        $metaDescription = $blog->meta_description ?: strip_tags($blog->short_description ?? '');
        return view('front.blog-details', compact('metaTitle', 'metaDescription', 'blog'));
    }

    public function contact(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
         $locators = Locator::where('status', 'Active')->orderBy('created_at', 'desc')->get();
        $siteSetting = Setting::first() ?? new Setting();

        return view('front.contact', compact('metaTitle', 'metaDescription','locators','siteSetting'));
    }

    public function thankYou()
    {
        return view('front.thank-you');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:120',
                "regex:/^[\\p{L}\\p{M}][\\p{L}\\p{M}0-9\\s.'\\x{2019}-]{1,119}$/u",
            ],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+().\s-]{7,30}$/'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $contact = Contact::create($validated);
        $timestamp  = Carbon::now()->format('Y-m-d H:i:s');
        $sheetsData = [
            'inquiry_type' => 'Contact Page',
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'phone' => $request->phone ?? '',
            'product' => '',
            'message' => $request->message ?? '',
            'date'  => $timestamp,
        ];
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])->post("https://script.google.com/macros/s/AKfycbzMzhwi18bHlO3k_TFqVPLfWpCp_ZsztpaPwQ4TVhzzOwd9OaYqnaiKw5JRmdqO7eTl/exec", $sheetsData);

            if ($response->failed()) {
                \Log::error('Google Sheet request failed: ' . $response->body());
            }
        } catch (\Throwable $exception) {
            Log::warning('Contact form was saved, but Google Sheets could not be reached.', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }

        $message ='Thank you. Your message has been sent.';

        return redirect()->route('contact.thank-you')->with('contact_status', $message);
    }
    
   public function submitQuote(Request $request)
{
    $validated = $request->validateWithBag('quote', [
        'name' => [
            'required',
            'string',
            'min:2',
            'max:120',
            "regex:/^[\\p{L}\\p{M}][\\p{L}\\p{M}0-9\\s.'\\x{2019}-]{1,119}$/u",
        ],
        'email' => ['required', 'email:rfc', 'max:255'],
        'phone' => ['nullable', 'digits_between:7,15'],        
        'product' => ['required', 'string', 'max:150'],
        'message' => ['nullable', 'string', 'max:5000'],
    ]);

    // 1. Database me save
    $contact = Contact::create([
    'name'    => $validated['name'],
    'email'   => $validated['email'],
    'phone'   => $validated['phone'] ?? null,
    'product' => $validated['product'],
    'message' => $validated['message'] ?? '',
]);

    // 2. Google Sheet me save
    $sheetsData = [
        'inquiry_type' => 'Pop Up Form',
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? '',
        'product' => $validated['product'],
        'message' => $validated['message'] ?? '',
        'date' => Carbon::now()->format('Y-m-d H:i:s'),
    ];

    try {
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://script.google.com/macros/s/AKfycbzMzhwi18bHlO3k_TFqVPLfWpCp_ZsztpaPwQ4TVhzzOwd9OaYqnaiKw5JRmdqO7eTl/exec", $sheetsData);

        if ($response->failed()) {
            Log::error('Google Sheet request failed (quote): ' . $response->body());
        }
    } catch (\Throwable $exception) {
        Log::warning('Quote request was saved, but Google Sheets could not be reached.', [
            'contact_id' => $contact->id,
            'error' => $exception->getMessage(),
        ]);
    }

    return redirect()
        ->route('contact.thank-you')
        ->with('contact_status', 'Thank you. Your quote request has been sent.');
}

    public function submitProductInquiry(Request $request)
    {
        $validated = $request->validateWithBag('productInquiry', [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:120',
                "regex:/^[\\p{L}\\p{M}][\\p{L}\\p{M}0-9\\s.'\\x{2019}-]{1,119}$/u",
            ],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'digits_between:7,15'],
            'product' => ['required', 'string', 'max:255'],
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(fn ($query) => $query->where('status', 'Active')),
            ],
            'message' => ['nullable', 'string', 'max:5000'],
        ]);

        $product = Product::whereKey($validated['product_id'])
            ->where('status', 'Active')
            ->firstOrFail();
        $productName = $product->name ?: $product->title;

        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'product' => $productName,
            'message' => $validated['message'] ?? '',
        ]);

        $sheetsData = [
            'inquiry_type' => 'Product Inquiry',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? '',
            'product' => $productName,
            'message' => $validated['message'] ?? '',
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post('https://script.google.com/macros/s/AKfycbzMzhwi18bHlO3k_TFqVPLfWpCp_ZsztpaPwQ4TVhzzOwd9OaYqnaiKw5JRmdqO7eTl/exec', $sheetsData);

            if ($response->failed()) {
                Log::error('Google Sheet request failed (product inquiry): ' . $response->body());
            }
        } catch (\Throwable $exception) {
            Log::warning('Product inquiry was saved, but Google Sheets could not be reached.', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return redirect()
            ->route('contact.thank-you')
            ->with('contact_status', 'Thank you. Your product inquiry has been sent.');
    }

    public function getNewsEvent(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $events = Event::where('status', 'Active')->orderByDesc('from_date')->orderByDesc('id')->get();
        return view('front.news-event', compact('metaTitle', 'metaDescription', 'events'));
    }

    public function technicalBrochure(Request $request){
    $metaTitle = '';
    $metaDescription = '';

    $sheets = TechnicalDataSheet::with('category')
        ->where('status', 'Active')
        //->whereHas('category', fn ($q) => $q->where('status', 'Active'))
        ->latest('created_at')
        ->get();

    $categories = $sheets->pluck('category')->unique('id')->sortBy('title')->values();

    return view('front.technical-brochure', compact('metaTitle', 'metaDescription', 'sheets', 'categories'));
}

    public function productList(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $category = null;
        $query = Product::with('category')
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc');

        if ($search = trim((string) $requesr->query('q'))) {
            $query->where(function ($products) use ($search) {
                $products->where('name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $products = $query->get();

        return view('front.product-list', compact('metaTitle', 'metaDescription', 'products', 'category'));
    }

    public function categoryProducts(string $categoryUrl)
    {
        $category = Category::where('category_url', $categoryUrl)
            ->where('status', 'Active')
            ->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->get();
        $metaTitle = $category->meta_title ?: $category->title;
        $metaDescription = $category->meta_description ?: $category->description;

        return view('front.product-list', compact('metaTitle', 'metaDescription', 'products', 'category'));
    }

   public function productDetails(Request $request, $productUrl)
{
    $product = Product::with('category')
        ->where('product_url', $productUrl)
        ->where('status', 'Active')
        ->firstOrFail();

    $metaTitle = $product->title . ' | Pratham Filter Industries';
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160);

    return view('front.product-details', compact('product', 'metaTitle', 'metaDescription'));
}

    
    
    
}
