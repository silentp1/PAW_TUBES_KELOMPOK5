@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Movie Management</h1>
        <a href="{{ route('admin.movies.create') }}" class="btn-primary" style="text-decoration: none;">+ Add Movie</a>
    </div>

    <div style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.movies.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
            
            <select name="genre" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Genres</option>
                <option value="Action" {{ request('genre') == 'Action' ? 'selected' : '' }}>Action</option>
                <option value="Comedy" {{ request('genre') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
                <option value="Drama" {{ request('genre') == 'Drama' ? 'selected' : '' }}>Drama</option>
                <option value="Horror" {{ request('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
                <option value="Sci-Fi" {{ request('genre') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
            </select>

            <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Status</option>
                <option value="now_showing" {{ request('status') == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                <option value="coming_soon" {{ request('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.movies.index') }}" style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Title</th>
                    <th style="padding: 15px;">Genre</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: 500;">{{ $movie->title }}</td>
                        <td style="padding: 15px; color: #666;">{{ $movie->genre }}</td>
                        <td style="padding: 15px;">
                            @if($movie->status == 'now_showing')
                                <span style="background: #e6fffa; color: #2c7a7b; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Now Showing</span>
                            @elseif($movie->status == 'coming_soon')
                                <span style="background: #fffaf0; color: #c05621; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Coming Soon</span>
                            @else
                                <span style="background: #edf2f7; color: #4a5568; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" style="color: blue; text-decoration: none; margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
