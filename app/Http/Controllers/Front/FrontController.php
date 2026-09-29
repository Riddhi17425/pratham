<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Event;
use App\Models\OurBrand;
use App\Models\Partner;
use Illuminate\Http\Request;

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
