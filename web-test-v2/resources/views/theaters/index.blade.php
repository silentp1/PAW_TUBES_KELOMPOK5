@extends('layouts.app')

@section('title', 'Theaters')

@section('content')
    <div class="theater-index" style="padding: 30px; max-width: 1400px; margin: 0 auto;">
        <!-- Header Section -->
        <div class="theater-header"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center;">
                    <img src="{{ asset('back_arrow.png') }}" alt="Back"
                        style="width: 24px; height: 24px; filter: brightness(0);"> <!-- Black arrow -->
                </a>
                <h2 style="margin: 0;">Theaters</h2>
            </div>

            <!-- Controls -->
            <div style="display: flex; gap: 15px; align-items: center;">
                <form action="{{ route('theaters.index') }}" method="GET" style="display: flex; gap: 15px; margin: 0;">
                    <!-- City Dropdown -->
                    <div style="position: relative;">
                        <select name="city" onchange="this.form.submit()"
                            style="padding: 12px 35px 12px 20px; border-radius: 8px; border: 1px solid var(--border); font-size: 1rem; cursor: pointer; outline: none; background: white url('{{ asset('filter_icon.png') }}') no-repeat right 15px center; background-size: 30px; color: #333; min-width: 160px; appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                            <option value="">All Location</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        <!-- Custom arrow could be added here via CSS/Pseudo -->
                    </div>

                    <!-- Search Input -->
                    <input class="search-input" type="text" name="search" placeholder="Search Theaters"
                        value="{{ request('search') }}"
                        style="padding: 12px 20px; border-radius: 8px; border: 1px solid var(--border); width: 300px; outline: none; font-size: 1rem; background: #004d57; color: white;">

                    <!-- Search Button -->
                    <button type="submit"
                        style="background: #00838f; color: white; border: none; padding: 12px 30px; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: 600;">
                        Search
                    </button>

                    @if(request('city'))
                        <input type="hidden" name="city" value="{{ request('city') }}">
                    @endif
                </form>
            </div>
        </div>

        <!-- Theater Grid -->
        <div class="theater-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            @foreach($theaters as $theater)
                <div class="theater-card"
                    style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;">

                    <!-- Image -->
                    <!-- Image -->
                    <a href="{{ route('theaters.show', $theater->id) }}" style="display: block; text-decoration: none;">
                        <div class="theater-img" style="height: 250px; overflow: hidden;">
                            <img src="{{ $theater->image }}" alt="{{ $theater->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="theater-info" style="padding: 25px;">
                        <h3 style="font-size: 1.4rem; margin-bottom: 10px; color: black; font-weight: 700;">{{ $theater->name }}
                        </h3>

                        <div style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 15px;">
                            <span style="color: #d32f2f;">📍</span>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.5; margin: 0;">
                                {{ $theater->address }}</p>
                        </div>

                        <a href="{{ route('theaters.show', $theater->id) }}"
                            style="display: inline-block; color: #6200ea; font-weight: 700; text-decoration: none; font-size: 0.95rem;">
                            Check Schedule
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .theater-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection