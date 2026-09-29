<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Event;
use App\Models\OurBrand;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function home(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $banners = Banner::where('status', 'Active')->latest()->get();
        $partners = Partner::where('status', 'Active')->latest()->get();
        $brands = OurBrand::where('status', 'Active')->latest()->get();
        $blogs = Blog::where('status', 'Active')->orderByDesc('date')->orderByDesc('id')->take(4)->get();

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
        $blogs = Blog::where('status', 'Active')->orderByDesc('date')->orderByDesc('id')->get();
        return view('front.blogs', compact('metaTitle', 'metaDescription', 'blogs'));
    }

    public function blogDetails(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.blog-details', compact('metaTitle', 'metaDescription'));
    }

    public function contact(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.contact', compact('metaTitle', 'metaDescription'));
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

    public function getNewsEvent(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        $events = Event::where('status', 'Active')->orderByDesc('date')->orderByDesc('id')->get();
        return view('front.news-event', compact('metaTitle', 'metaDescription', 'events'));
    }

    public function technicalBrochure(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.technical-brochure', compact('metaTitle', 'metaDescription'));
    }

    public function productList(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.product-list', compact('metaTitle', 'metaDescription'));
    }

    public function productDetails(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.product-details', compact('metaTitle', 'metaDescription'));
    }

    
    
    
}
