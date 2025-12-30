@extends('layouts.admin')

@section('content')
    <div
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Add New Movie</h2>

        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Movie Title</label>
                <input type="text" name="title" required placeholder="e.g. Inception">
            </div>

            <div class="form-group">
                <label>Genre</label>
                <input type="text" name="genre" required placeholder="e.g. Sci-Fi, Action">
            </div>

            <div class="form-group">
                <label>Duration (Minutes)</label>
                <input type="number" name="duration" required placeholder="e.g. 148">
            </div>

            <div class="form-group">
                <label>Poster Image</label>
                <input type="file" name="poster" required accept="image/*">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="now_showing">Now Showing</option>
                    <option value="coming_soon">Coming Soon</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label>Synopsis</label>
                <textarea name="synopsis" rows="4" required placeholder="Movie description..."></textarea>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%;">Add Movie</button>
        </form>
    </div>
@endsection