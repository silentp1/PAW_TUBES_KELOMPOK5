<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Theater;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with([
            'movie' => function ($query) {
                $query->withTrashed();
            },
            'theater'
        ])->orderBy('date')->orderBy('start_time');

        if ($request->has('movie_id') && $request->movie_id != '') {
            $query->where('movie_id', $request->movie_id);
        }

        if ($request->has('theater_id') && $request->theater_id != '') {
            $query->where('theater_id', $request->theater_id);
        }

        if ($request->has('date') && $request->date != '') {
            $query->where('date', $request->date);
        }

        $schedules = $query->get();
        $movies = Movie::select('id', 'title')->orderBy('title')->get();
        $theaters = Theater::select('id', 'name')->orderBy('name')->get();

        return view('admin.schedules.index', compact('schedules', 'movies', 'theaters'));
    }

    public function create()
    {
        $movies = Movie::where('status', 'now_showing')->get();
        $theaters = Theater::all();
        return view('admin.schedules.create', compact('movies', 'theaters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i',
        ]);

        $movie = Movie::findOrFail($validated['movie_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $successCount = 0;
        $failCount = 0;

        // Loop through dates
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $currentDate = $date->format('Y-m-d');

            // Loop through times
            foreach ($validated['times'] as $time) {
                // Calculate End Time
                $startDateTime = Carbon::parse($currentDate . ' ' . $time);
                $endDateTime = $startDateTime->copy()->addMinutes($movie->duration + 15);
                $endTimeString = $endDateTime->format('H:i');

                // Conflict Check
                $conflict = Schedule::where('theater_id', $validated['theater_id'])
                    ->where('date', $currentDate)
                    ->where(function ($query) use ($time, $endTimeString) {
                        $query->where('start_time', '<', $endTimeString)
                            ->where('end_time', '>', $time);
                    })
                    ->exists();

                if (!$conflict) {
                    // Pricing Logic
                    $dayOfWeek = $date->dayOfWeek;
                    $isWeekend = ($dayOfWeek == 0 || $dayOfWeek == 5 || $dayOfWeek == 6);
                    $price = $isWeekend ? 50000 : 35000;

                    Schedule::create([
                        'movie_id' => $validated['movie_id'],
                        'theater_id' => $validated['theater_id'],
                        'date' => $currentDate,
                        'start_time' => $time,
                        'end_time' => $endTimeString,
                        'price' => $price,
                    ]);
                    $successCount++;
                } else {
                    $failCount++;
                }
            }
        }

        if ($successCount == 0 && $failCount > 0) {
            return back()->withErrors(['theater_id' => 'All selected slots are conflicting with existing schedules.']);
        }

        return redirect()->route('admin.schedules.index')->with('success', "$successCount schedules created. $failCount skipped due to conflicts.");
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }
}
