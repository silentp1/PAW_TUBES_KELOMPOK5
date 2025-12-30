@extends('layouts.app')

@section('title', 'All Movies')

@section('content')
    <div style="padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center;">
                    <img src="{{ asset('back_arrow.png') }}" alt="Back" style="width: 24px; height: 24px;">
                </a>
                <h2 style="margin: 0;">Movies</h2>
            </div>

            <form action="{{ route('movies.index') }}" method="GET" style="display: flex; gap: 10px;">
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <input class="search-input" type="text" name="search" placeholder="Search movies..."
                    value="{{ request('search') }}"
                    style="padding: 8px 15px; border-radius: 20px; border: 1px solid var(--border); width: 250px; outline: none; background: linear-gradient(to right, #007180, #00171A); color: white;">
                <button type="submit"
                    style="background: var(--primary); color: white; border: none; padding: 8px 15px; border-radius: 20px; cursor: pointer;">
                    Search
                </button>
            </form>
        </div>

        <!-- Filters -->
        <div class="movie-filters" style="margin-bottom: 30px; display: flex; gap: 10px;">

            <a href="{{ route('movies.index', ['filter' => 'now_showing']) }}"
                class="filter-btn {{ request('filter') == 'now_showing' || request('filter') == null ? 'active' : '' }}">Now
                Showing</a>
            <a href="{{ route('movies.index', ['filter' => 'coming_soon']) }}"
                class="filter-btn {{ request('filter') == 'coming_soon' ? 'active' : '' }}">Coming Soon</a>
            <a href="{{ route('movies.index', ['filter' => 'trending']) }}"
                class="filter-btn {{ request('filter') == 'trending' ? 'active' : '' }}">Trending</a>
        </div>

        <style>
            .search-input::placeholder {
                color: rgba(255, 255, 255, 0.7);
            }
            .filter-btn {
                text-decoration: none;
                padding: 8px 20px;
                border-radius: 20px;
                background: white;
                color: var(--text-muted);
                border: 1px solid var(--border);
                font-weight: 500;
                transition: 0.2s;
            }

            .filter-btn:hover,
            .filter-btn.active {
                background: var(--primary);
                color: white;
                border-color: var(--primary);
            }
        </style>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px;">
            @foreach($movies as $movie)
                <div
                    style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s;">
                    <a href="{{ route('movies.show', $movie->id) }}" style="text-decoration: none; color: inherit;">
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
                            style="width: 100%; height: 300px; object-fit: cover;">
                        <div style="padding: 15px;">
                            <h3
                                style="font-size: 1.1rem; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $movie->title }}
                            </h3>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; color: var(--text-muted); font-size: 0.9rem;">
                                <span>{{ $movie->genre }}</span>
                                <span style="color: var(--accent);">★ {{ $movie->rating }}</span>
                            </div>
                            <div
                                style="margin-top: 10px; text-align: center; background: {{ $movie->status == 'now_showing' ? 'var(--primary)' : '#9ca3af' }}; color: white; padding: 8px; border-radius: 5px; font-weight: 500;">
                                {{ $movie->status == 'now_showing' ? 'Book Now' : 'Coming Soon' }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection