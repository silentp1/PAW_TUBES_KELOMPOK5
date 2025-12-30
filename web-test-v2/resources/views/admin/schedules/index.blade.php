@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Manage Schedules</h1>
        <a href="{{ route('admin.schedules.create') }}" class="btn-primary" style="text-decoration: none;">+ Add
            Schedule</a>
    </div>

    <div
        style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.schedules.index') }}" method="GET"
            style="display: flex; gap: 10px; align-items: center;">
            <select name="movie_id" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; max-width: 200px;">
                <option value="">All Movies</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" {{ request('movie_id') == $movie->id ? 'selected' : '' }}>{{ $movie->title }}
                    </option>
                @endforeach
            </select>

            <select name="theater_id" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; max-width: 200px;">
                <option value="">All Theaters</option>
                @foreach($theaters as $theater)
                    <option value="{{ $theater->id }}" {{ request('theater_id') == $theater->id ? 'selected' : '' }}>
                        {{ $theater->name }}</option>
                @endforeach
            </select>

            <input type="date" name="date" value="{{ request('date') }}"
                style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">

            <button type="submit"
                style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.schedules.index') }}"
                style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Date</th>
                    <th style="padding: 15px;">Time</th>
                    <th style="padding: 15px;">Movie</th>
                    <th style="padding: 15px;">Studio</th>
                    <th style="padding: 15px;">Price</th>
                    <th style="padding: 15px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">{{ $schedule->date }}</td>
                        <td style="padding: 15px;">{{ substr($schedule->start_time, 0, 5) }} -
                            {{ substr($schedule->end_time, 0, 5) }}
                        </td>
                        <td style="padding: 15px; font-weight: 500;">
                            {{ $schedule->movie ? $schedule->movie->title : 'Movie Deleted' }}
                        </td>
                        <td style="padding: 15px; color: #666;">{{ $schedule->theater->name }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;"
                                    onclick="return confirm('Delete schedule?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection