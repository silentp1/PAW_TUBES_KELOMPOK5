<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{
    // List Theaters
    public function index(Request $request)
    {
        $query = Theater::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        $theaters = $query->get();
        // Get unique cities for filter dropdown
        $cities = Theater::select('city')->distinct()->pluck('city');

        return view('admin.theaters.index', compact('theaters', 'cities'));
    }

    // Show Create Form
    public function create()
    {
        $locations = Location::all();
        return view('admin.theaters.create', compact('locations'));
    }

    // Store New Theater
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle File Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('theaters', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        Theater::create($validated);

        return redirect()->route('admin.theaters.index')->with('success', 'Theater added successfully!');
    }

    // Show Edit Form
    public function edit($id)
    {
        $theater = Theater::findOrFail($id);
        $locations = Location::all();
        return view('admin.theaters.edit', compact('theater', 'locations'));
    }

    // Update Theater
    public function update(Request $request, $id)
    {
        $theater = Theater::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists and is local (starts with /storage)
            if ($theater->image && str_starts_with($theater->image, '/storage')) {
                $oldPath = str_replace('/storage/', '', $theater->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('theaters', 'public');
            $validated['image'] = '/storage/' . $path;
        } else {
            unset($validated['image']);
        }

        $theater->update($validated);

        return redirect()->route('admin.theaters.index')->with('success', 'Theater updated successfully!');
    }

    // Delete Theater
    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);

        if ($theater->image && str_starts_with($theater->image, '/storage')) {
            $oldPath = str_replace('/storage/', '', $theater->image);
            Storage::disk('public')->delete($oldPath);
        }

        $theater->delete();

        return redirect()->route('admin.theaters.index')->with('success', 'Theater deleted successfully!');
    }
}
