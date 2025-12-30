<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Booking;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Fetch movies with filters
        $query = Movie::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $movies = $query->get();

        // Calculate statistics
        $analytics = $movies->map(function ($movie) {
            // Get all paid bookings for this movie
            $paidBookings = $movie->bookings()->where('status', 'paid')->get();

            // Sum up the number of seats (viewers)
            $totalViewers = $paidBookings->sum(function ($booking) {
                // Ensure seats is an array (it might be automatically cast depending on model, but safe to check)
                $seats = is_array($booking->seats) ? $booking->seats : json_decode($booking->seats, true);
                return is_array($seats) ? count($seats) : 0;
            });

            return [
                'title' => $movie->title,
                'poster' => $movie->poster,
                'total_viewers' => $totalViewers,
                'status' => $movie->status
            ];
        });

        // Sort by viewers
        if ($request->input('sort_viewers') == 'asc') {
            $analytics = $analytics->sortBy('total_viewers');
        } else {
            $analytics = $analytics->sortByDesc('total_viewers');
        }

        return view('admin.analytics.index', compact('analytics'));
    }
}
