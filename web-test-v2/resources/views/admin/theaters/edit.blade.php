@extends('layouts.admin')

@section('content')
    <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.theaters.index') }}"
            style="text-decoration: none; font-size: 1.5rem; color: #333;">&larr;</a>
        <h1>Edit Theater</h1>
    </div>

    <div
        style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.theaters.update', $theater->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Theater Name</label>
                <input type="text" name="name" value="{{ $theater->name }}" required>
            </div>

            <div class="form-group">
                <label>City</label>
                <select name="city" required>
                    <option value="">Select City</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->name }}" {{ $theater->city == $loc->name ? 'selected' : '' }}>{{ $loc->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ $theater->address }}</textarea>
            </div>

            <div class="form-group">
                <label>Current Image</label>
                <div style="margin-bottom: 10px;">
                    <img src="{{ $theater->image }}" alt="Current" style="height: 100px; border-radius: 5px;">
                </div>
                <label>Change Image (Optional)</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn-primary" style="margin-top: 10px; width: 100%;">Update Theater</button>
        </form>
    </div>
@endsection