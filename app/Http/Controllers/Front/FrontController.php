<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function home(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.home', compact('metaTitle', 'metaDescription'));
    }

    public function about(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.about', compact('metaTitle', 'metaDescription'));
    }

    public function getBlogs(Request $requesr){
        $metaTitle = '';
        $metaDescription = '';
        return view('front.blogs', compact('metaTitle', 'metaDescription'));
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
        return view('front.news-event', compact('metaTitle', 'metaDescription'));
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
