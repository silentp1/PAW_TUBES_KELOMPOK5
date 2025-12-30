@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div style="padding: 40px; max-width: 600px; margin: 0 auto;">
        <div
            style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 500px;">
            <div
                style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                <img src="{{ asset('notification_icon.png') }}" alt="Notification" style="width: 40px; height: 40px;">
                <h1 style="color: #333; font-size: 1.5rem; margin: 0;">Notifications</h1>
            </div>

            <div style="text-align: center; padding-top: 50px; color: #888;">
                <div style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;">🔕</div>
                <p>No new notifications at the moment.</p>
                <p style="font-size: 0.9rem;">We'll let you know when there are updates on your bookings or new movie
                    releases!</p>
            </div>

            <div style="margin-top: 100px; text-align: center;">
                <a href="{{ route('home') }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">&larr;
                    Back to Home</a>
            </div>
        </div>
    </div>
@endsection