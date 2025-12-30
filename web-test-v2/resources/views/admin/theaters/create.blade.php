@extends('layouts.admin')

@section('content')
    <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.theaters.index') }}"
            style="text-decoration: none; font-size: 1.5rem; color: #333;">&larr;</a>
        <h1>Add New Theater</h1>
    </div>

    <div
        style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.theaters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Theater Name</label>
                <input type="text" name="name" required placeholder="e.g. CGV Grand Indonesia">
            </div>

            <div class="form-group">
                <label>City</label>
                <select name="city" required>
                    <option value="">Select City</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->name }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3" required placeholder="Full address..."
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            </div>

            <div class="form-group">
                <label>Theater Image</label>
                <input type="file" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn-primary" style="margin-top: 10px; width: 100%;">Save Theater</button>
        </form>
    </div>
@endsection