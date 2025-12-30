<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Theater;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $movieId = $request->query('movie_id');
        $theaterId = $request->query('theater_id');

        $movie = Movie::findOrFail($movieId);
        $theater = Theater::findOrFail($theaterId);

        return view('booking', compact('movie', 'theater'));
    }
}
