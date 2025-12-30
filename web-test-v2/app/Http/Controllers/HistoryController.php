<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            // Show all statuses (pending, paid, cancelled)
            ->with('movie') // Eager load movie
            ->orderBy('created_at', 'desc')
            ->get();

        // Key by booking_id to allow multiple reviews for same movie (different transactions)
        $myReviews = Review::where('user_id', Auth::id())
            ->whereNotNull('booking_id')
            ->get()
            ->keyBy('booking_id');

        return view('history.index', compact('bookings', 'myReviews'));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // Prevent duplicate review for the SAME BOOKING
        if (Review::where('user_id', Auth::id())->where('booking_id', $validated['booking_id'])->exists()) {
            return back()->with('error', 'You have already rated this transaction.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'movie_id' => $validated['movie_id'],
            'booking_id' => $validated['booking_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        // Update Movie Rating (Simple Average)
        $movie = \App\Models\Movie::find($validated['movie_id']);
        $avg = Review::where('movie_id', $movie->id)->avg('rating');
        $movie->rating = round($avg, 1);
        $movie->save();

        return back()->with('success', 'Thank you for your rating!');
    }
}
