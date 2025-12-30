@extends('layouts.admin')

@section('content')
    <h1>Dashboard</h1>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 30px;">
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin: 0; color: #666;">Total Users</h3>
            <p style="font-size: 2rem; margin: 10px 0; font-weight: bold;">{{ $stats['total_users'] }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin: 0; color: #666;">Movies (Showing)</h3>
            <p style="font-size: 2rem; margin: 10px 0; font-weight: bold;">{{ $stats['movies_now_showing'] }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin: 0; color: #666;">Movies (Coming Soon)</h3>
            <p style="font-size: 2rem; margin: 10px 0; font-weight: bold;">{{ $stats['movies_coming_soon'] }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin: 0; color: #666;">Total Tickets</h3>
            <p style="font-size: 2rem; margin: 10px 0; font-weight: bold;">{{ $stats['total_bookings'] }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="margin-top: 40px;">
        <h2>Quick Actions</h2>
        <a href="{{ route('admin.movies.create') }}" class="btn-primary"
            style="text-decoration:none; display:inline-block;">+ Add
            New Movie</a>
    </div>
@endsection