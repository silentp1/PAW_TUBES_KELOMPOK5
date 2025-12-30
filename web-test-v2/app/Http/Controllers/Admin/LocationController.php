<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    // List Locations
    public function index(Request $request)
    {
        $query = Location::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $locations = $query->get();
        return view('admin.locations.index', compact('locations'));
    }

    // Show Create Form
    public function create()
    {
        return view('admin.locations.create');
    }

    // Store New Location
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location added successfully!');
    }

    // Delete Location
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully!');
    }
}
