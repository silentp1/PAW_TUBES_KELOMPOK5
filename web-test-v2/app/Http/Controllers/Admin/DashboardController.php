<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Gather some stats for the dashboard
        $stats = [
            'total_movies' => Movie::count(),
            'total_users' => User::where('role', 'customer')->count(),
            'total_bookings' => Booking::count(),
            'movies_now_showing' => Movie::where('status', 'now_showing')->count(),
            'movies_coming_soon' => Movie::where('status', 'coming_soon')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
