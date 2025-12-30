@extends('layouts.app')

@section('title', 'Customer Service')

@section('content')
    <div style="padding: 40px; max-width: 800px; margin: 0 auto; text-align: center;">
        <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <img src="{{ asset('cs_icon.png') }}" alt="Customer Service"
                style="width: 80px; height: 80px; margin-bottom: 20px; opacity: 0.8;">

            <h1 style="color: #333; margin-bottom: 10px; font-size: 2rem;">Customer Service</h1>
            <p style="color: #666; margin-bottom: 30px; font-size: 1.1rem;">We are here to help! Reach out to us for any
                inquiries.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: left;">
                <div style="padding: 20px; border: 1px solid #eee; border-radius: 12px;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">📧 Email Us</h3>
                    <p style="color: #555;">support@cinespot.com</p>
                    <p style="color: #888; font-size: 0.9rem;">Response within 24 hours</p>
                </div>

                <div style="padding: 20px; border: 1px solid #eee; border-radius: 12px;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">📞 Call Us</h3>
                    <p style="color: #555;">+62 123 4567 890</p>
                    <p style="color: #888; font-size: 0.9rem;">Mon - Fri, 09:00 - 17:00</p>
                </div>
            </div>

            <div style="margin-top: 40px;">
                <a href="{{ route('home') }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">&larr;
                    Back to Home</a>
            </div>
        </div>
    </div>
@endsection