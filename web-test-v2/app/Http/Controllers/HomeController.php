<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        // Trending: Top 10 by rating
        $trending = Movie::where('status', 'now_showing')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        // Now Showing: Limit 10, latest first
        $nowShowing = Movie::where('status', 'now_showing')
            ->latest()
            ->take(10)
            ->get();

        // Coming Soon: Limit 10
        $comingSoon = Movie::where('status', 'coming_soon')
            ->latest()
            ->take(10)
            ->get();

        // Slideshow: Take top 5 rated movies
        $slideshow = Movie::where('status', 'now_showing')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('trending', 'nowShowing', 'comingSoon', 'slideshow'));
    }
}
