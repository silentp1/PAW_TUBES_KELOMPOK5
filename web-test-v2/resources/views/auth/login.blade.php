    @extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div
        style="max-width: 400px; margin: 50px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h2 style="text-align: center; margin-bottom: 30px; font-size: 1.8rem;">Welcome Back</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Email
                    Address</label>
                <input type="email" name="email" required
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s;"
                    placeholder="name@example.com">
            </div>

            <div style="margin-bottom: 30px;">
                <label
                    style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Password</label>
                <input type="password" name="password" required
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 1rem; outline: none;"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                style="width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: 0.2s;">
                Sign In
            </button>
        </form>

        <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
            Don't have an account? <a href="{{ route('register') }}"
                style="color: var(--primary); font-weight: 500;">Register here</a>
        </div>
    </div>
@endsection