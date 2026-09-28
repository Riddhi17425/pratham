<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function home(Request $requesr){
        return view('front.home');
    }

    public function about(Request $requesr){
        return view('front.about');
    }

    public function getBlogs(Request $requesr){
        return view('front.blogs');
    }

    public function blogDetails(Request $requesr){
        return view('front.blog-details');
    }

    public function contact(Request $requesr){
        return view('front.contact');
    }

    public function getNewsEvent(Request $requesr){
        return view('front.news-event');
    }

    public function technicalBrochure(Request $requesr){
        return view('front.technical-brochure');
    }

    public function productList(Request $requesr){
        return view('front.product-list');
    }

    public function productDetails(Request $requesr){
        return view('front.product-details');
    }

    
    
    
}
