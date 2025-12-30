@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Location Management</h1>
        <a href="{{ route('admin.locations.create') }}" class="btn-primary" style="text-decoration: none;">+ Add
            Location</a>
    </div>

    <div
        style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.locations.index') }}" method="GET"
            style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="Search by city name..." value="{{ request('search') }}"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
            <button type="submit"
                style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Search</button>
            <a href="{{ route('admin.locations.index') }}"
                style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">City Name</th>
                    <th style="padding: 15px;">Created At</th>
                    <th style="padding: 15px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: 500;">{{ $location->name }}</td>
                        <td style="padding: 15px; color: #666;">{{ $location->created_at->format('d M Y') }}</td>
                        <td style="padding: 15px;">
                            <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection