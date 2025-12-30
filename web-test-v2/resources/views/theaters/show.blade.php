@extends('layouts.app')

@section('title', $theater->name)

@section('content')
    <div class="theater-detail" style="padding: 40px; max-width: 1400px; margin: 0 auto;">
        <!-- Theater Header -->
        <div class="theater-header"
            style="background: white; padding: 40px; border-radius: 12px; margin-bottom: 40px; display: flex; gap: 40px; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <img src="{{ $theater->image }}" alt="{{ $theater->name }}"
                style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid var(--bg-secondary);">

            <div>
                <h1 style="font-size: 2.5rem; margin-bottom: 10px;">{{ $theater->name }}</h1>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 5px;">📍 {{ $theater->address }}</p>
                <p style="font-size: 1rem; color: var(--text-muted);">{{ $theater->city }}</p>
            </div>
        </div>

        <!-- Now Showing List -->
        <h3 style="font-size: 1.8rem; margin-bottom: 25px;">Now Showing at {{ $theater->name }}</h3>

        @if($movies->count() > 0)
            <div class="movie-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 30px;">
                @foreach($movies as $movie)
                    <div class="movie-card-home"
                        style="background: white; border-radius: 10px; padding: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.2s;">
                        <a href="{{ route('movies.show', $movie->id) }}" style="text-decoration:none; color:inherit;">
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
                                style="width: 100%; border-radius: 8px; height: 280px; object-fit: cover;">
                            <h3 style="margin-top: 10px; font-size: 1.1rem; color: #333;">{{ $movie->title }}</h3>
                            <p style="font-size: 0.8rem; color: #888;">{{ $movie->genre }} • {{ $movie->duration }}m</p>
                            <div
                                style="margin-top: 10px; background: var(--primary); color: white; text-align: center; padding: 8px; border-radius: 5px; font-weight: 500;">
                                Book Now
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 50px; color: var(--text-muted);">
                No movies scheduled currently.
            </div>
        @endif

    </div>
@endsection