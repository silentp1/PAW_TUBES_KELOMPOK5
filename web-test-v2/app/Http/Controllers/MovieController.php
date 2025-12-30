<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Carbon\Carbon;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        // Search Filter
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filter == 'now_showing') {
            $query->where('status', 'now_showing');
        } elseif ($request->filter == 'coming_soon') {
            $query->where('status', 'coming_soon');
        } elseif ($request->filter == 'trending') {
            $query->where('status', 'now_showing')->orderBy('rating', 'desc');
        } else {
            // Default: Show Now Showing ONLY
            $query->where('status', 'now_showing');
        }

        $movies = $query->get();

        return view('movies.index', compact('movies'));
    }

    public function show($id)
    {
        $movie = Movie::with('theaters')->findOrFail($id);
        $reviews = \App\Models\Review::where('movie_id', $id)->with('user')->latest()->get();

        // Generate Schedule from Database
        $schedules = \App\Models\Schedule::where('movie_id', $id)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Group by Theater -> Date
        $schedulesGrouped = [];
        $theaterIds = [];

        foreach ($schedules as $s) {
            $dateKey = Carbon::parse($s->date)->format('Y-m-d');
            $schedulesGrouped[$s->theater_id][$dateKey][] = [
                'time' => Carbon::parse($s->start_time)->format('H:i'),
                'price' => $s->price,
                'full_date' => $s->date, // Ensure Y-m-d format
            ];
            $theaterIds[] = $s->theater_id;
        }

        // Get Theaters that actually have schedules
        $theaters = \App\Models\Theater::whereIn('id', array_unique($theaterIds))->get();

        return view('movies.show', compact('movie', 'reviews', 'schedulesGrouped', 'theaters'));
    }
}
