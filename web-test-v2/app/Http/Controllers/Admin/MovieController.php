<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    // List Movies
    public function index(Request $request)
    {
        $query = Movie::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('genre') && $request->genre != '') {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $movies = $query->get();
        return view('admin.movies.index', compact('movies'));
    }

    // Show Create Form
    public function create()
    {
        return view('admin.movies.create');
    }

    // Store New Movie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'genre' => 'required',
            'duration' => 'required|integer',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:now_showing,coming_soon,inactive',
        ]);

        // Handle File Upload
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $path;
        }

        Movie::create($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Movie added successfully!');
    }

    // Show Edit Form
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    // Update Movie
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'genre' => 'required',
            'duration' => 'required|integer',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:now_showing,coming_soon,inactive',
        ]);

        if ($request->hasFile('poster')) {
            // Delete old poster if exists and is NOT a URL
            if ($movie->poster && !str_starts_with($movie->poster, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($movie->poster);
            }
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $path;
        } else {
            // Remove poster from validated so it doesn't overwrite with null
            unset($validated['poster']);
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
    }

    // Delete Movie
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
}
