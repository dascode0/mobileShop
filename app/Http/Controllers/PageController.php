<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function about()
    {
        return view('page.about');
    }
    public function news()
    {
        return view('page.news');
    }
    public function contact()
    {
        return view('page.contact');
    }
}
