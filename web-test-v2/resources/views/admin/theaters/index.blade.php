@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Theater Management</h1>
        <a href="{{ route('admin.theaters.create') }}" class="btn-primary" style="text-decoration: none;">+ Add Theater</a>
    </div>

    <div
        style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.theaters.index') }}" method="GET"
            style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">

            <select name="city" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>

            <button type="submit"
                style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.theaters.index') }}"
                style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Name</th>
                    <th style="padding: 15px;">City</th>
                    <th style="padding: 15px;">Address</th>
                    <th style="padding: 15px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($theaters as $theater)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: 500;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ $theater->image }}"
                                    style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                {{ $theater->name }}
                            </div>
                        </td>
                        <td style="padding: 15px; color: #666;">{{ $theater->city }}</td>
                        <td style="padding: 15px; color: #666;">{{ Str::limit($theater->address, 50) }}</td>
                        <td style="padding: 15px;">
                            <a href="{{ route('admin.theaters.edit', $theater->id) }}"
                                style="color: blue; text-decoration: none; margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.theaters.destroy', $theater->id) }}" method="POST"
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