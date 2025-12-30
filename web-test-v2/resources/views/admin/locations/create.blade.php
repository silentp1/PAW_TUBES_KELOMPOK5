@extends('layouts.admin')

@section('content')
    <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.locations.index') }}"
            style="text-decoration: none; font-size: 1.5rem; color: #333;">&larr;</a>
        <h1>Add New Location</h1>
    </div>

    <div
        style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.locations.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>City Name</label>
                <input type="text" name="name" required placeholder="e.g. Jakarta">
            </div>

            <button type="submit" class="btn-primary" style="margin-top: 10px; width: 100%;">Save Location</button>
        </form>
    </div>
@endsection