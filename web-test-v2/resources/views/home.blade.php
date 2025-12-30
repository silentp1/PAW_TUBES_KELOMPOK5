@extends('layouts.app')

@section('title', 'Movies')

@section('content')
    <div class="home-container" style="padding: 30px; overflow-y: auto; height: 100%;">

        <!-- Main Search Bar -->
        <div class="search-container" style="display: flex; justify-content: center; margin-bottom: 30px;">
            <form action="{{ route('movies.index') }}" method="GET"
                style="position: relative; width: 100%; max-width: 600px;">
                <input class="search-input" type="text" name="search" placeholder="Search movies..."
                    style="width: 100%; padding: 15px 25px; padding-left: 55px; border-radius: 30px; border: none; background: #004d57; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-size: 1rem; color: white; outline: none;">
                <img src="{{ asset('search_new.png') }}" alt="Search"
                    style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; opacity: 0.8; filter: brightness(0) invert(1);">
            </form>
            <style>
                .search-input::placeholder {
                    color: rgba(255, 255, 255, 0.7);
                }
            </style>
        </div>

        <!-- Dashboard Shortcuts (Centered, Icon-Box Style) -->
        <div class="dashboard-shortcuts" style="display: flex; justify-content: center; gap: 40px; margin-bottom: 40px;">

            <a href="{{ route('movies.index') }}" class="dashboard-shortcut-item"
                style="text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div class="icon-box"
                    style="width: 60px; height: 60px; background: #e0e0e0; border-radius: 12px; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('film.png') }}" alt="Movies" style="width: 30px; height: 30px; opacity: 0.8;">
                </div>
                <span style="font-size: 0.9rem; color: #333; font-weight: 500;">Movie</span>
            </a>

            <a href="{{ route('theaters.index') }}" class="dashboard-shortcut-item"
                style="text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div class="icon-box"
                    style="width: 60px; height: 60px; background: #e0e0e0; border-radius: 12px; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('theater.png') }}" alt="Theaters" style="width: 30px; height: 30px; opacity: 0.8;">
                </div>
                <span style="font-size: 0.9rem; color: #333; font-weight: 500;">Theater</span>
            </a>

            <a href="{{ route('history.index') }}" class="dashboard-shortcut-item"
                style="text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <div class="icon-box"
                    style="width: 60px; height: 60px; background: #e0e0e0; border-radius: 12px; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('history.png') }}" alt="History" style="width: 30px; height: 30px; opacity: 0.8;">
                </div>
                <span style="font-size: 0.9rem; color: #333; font-weight: 500;">History</span>
            </a>

        </div>




        <!-- Trending Slider -->
        @include('partials.movie_slider', [
            'id' => 'trending',
            'title' => 'Trending',

            'link' => route('movies.index', ['filter' => 'trending']),
            'movies' => $trending
        ])
            <!-- Now Showing Slider -->
                @include('partials.movie_slider', [
                    'id' => 'now-showing',
                    'title' => 'Now Showing',

                    'link' => route('movies.index', ['filter' => 'now_showing']),
                    'movies' => $nowShowing
                ])

        <!-- Coming Soon Slider -->
                @include('partials.movie_slider', [
                    'id' => 'coming-soon',
                    'title' => 'Coming Soon',

                    'link' => route('movies.index', ['filter' => 'coming_soon']),
                    'movies' => $comingSoon
                ])    
            </div>
@endsection