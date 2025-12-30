@extends('layouts.admin')

@section('content')
    <div
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Edit Movie</h2>

        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Movie Title</label>
                <input type="text" name="title" required value="{{ $movie->title }}">
            </div>

            <div class="form-group">
                <label>Genre</label>
                <input type="text" name="genre" required value="{{ $movie->genre }}">
            </div>

            <div class="form-group">
                <label>Duration (Minutes)</label>
                <input type="number" name="duration" required value="{{ $movie->duration }}">
            </div>

            <div class="form-group">
                <label>Poster Image (Leave empty to keep current)</label>
                <input type="file" name="poster" accept="image/*">
                @if($movie->poster)
                    <div style="margin-top: 10px;">
                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/' . $movie->poster) }}"
                            style="height: 100px; border-radius: 5px;">
                        <p style="font-size: 0.8rem; color: #666;">Current Poster</p>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="now_showing" {{ $movie->status == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                    <option value="coming_soon" {{ $movie->status == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                    <option value="inactive" {{ $movie->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label>Synopsis</label>
                <textarea name="synopsis" rows="4" required>{{ $movie->synopsis }}</textarea>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%;">Update Movie</button>
        </form>
    </div>
@endsection