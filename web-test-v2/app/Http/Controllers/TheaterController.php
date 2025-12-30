<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;

class TheaterController extends Controller
{
    public function index(Request $request)
    {
        // Get unique cities for the dropdown
        $cities = Theater::select('city')->distinct()->pluck('city');

        // Filter by city if selected
        // Filter by city if selected
        $query = Theater::query();
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        // Search Filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        $theaters = $query->get();

        return view('theaters.index', compact('theaters', 'cities'));
    }

    public function show($id)
    {
        // Get theater
        $theater = Theater::findOrFail($id);

        // Get Movies that have schedules at this theater (today or future)
        // We use the Schedule model to find distinct movie_ids
        $movieIds = \App\Models\Schedule::where('theater_id', $id)
            ->where('date', '>=', \Carbon\Carbon::today())
            ->pluck('movie_id')
            ->unique();

        $movies = \App\Models\Movie::whereIn('id', $movieIds)->get();

        return view('theaters.show', compact('theater', 'movies'));
    }
}
