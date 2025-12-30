@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div style="padding: 40px; max-width: 600px; margin: 0 auto;">
        <div
            style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">

            <div style="margin-bottom: 30px;">
                <img src="{{ asset('profile_icon.png') }}" alt="Profile"
                    style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--primary); padding: 5px;">
            </div>

            <h1 style="color: #333; margin-bottom: 5px;">{{ Auth::user()->name }}</h1>
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">{{ Auth::user()->email }}</p>

            <div style="text-align: left; background: #f9f9f9; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                <div
                    style="margin-bottom: 15px; display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    <span style="color: #888;">Role</span>
                    <span style="font-weight: 600; text-transform: capitalize;">{{ Auth::user()->role }}</span>
                </div>
                <div
                    style="margin-bottom: 15px; display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    <span style="color: #888;">Joined</span>
                    <span style="font-weight: 600;">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #888;">Member Status</span>
                    <span style="font-weight: 600; color: gold;">Gold Member</span>
                </div>
            </div>

            <div style="display: flex; gap: 10px; justify-content: center;">

                <!-- Changed "My Workouts" to "My Bookings" to match context -->
                <a href="{{ route('history.index') }}"
                    style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; flex: 1;">My
                    History</a>

                <form action="{{ route('logout') }}" method="POST" style="flex: 1;">
                    @csrf
                    <button type="submit"
                        style="width: 100%; background: #ff4081; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Logout</button>
                </form>
            </div>
        </div>
    </div>
@endsection