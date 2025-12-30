@extends('layouts.admin')

@section('content')
    <div
        style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Add New Schedule</h2>

        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div style="background: #fed7d7; color: #c53030; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <label>Movie</label>
                <select name="movie_id" required>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->title }} ({{ $movie->duration }}m)</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Studio / Theater</label>
                <select name="theater_id" required>
                    @foreach($theaters as $theater)
                        <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Start Date</label>
                    <input type="date" name="start_date" required min="{{ date('Y-m-d') }}">
                </div>
                <div style="flex: 1;">
                    <label>End Date</label>
                    <input type="date" name="end_date" required min="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Time Slots</label>
                <div id="time-slots-container">
                    <div class="time-slot" style="margin-bottom: 10px; display: flex; gap: 10px;">
                        <input type="time" name="times[]" required style="flex: 1;">
                        <button type="button" onclick="removeTimeSlot(this)"
                            style="background: #e53e3e; color: white; border: none; padding: 5px 10px; border-radius: 5px;">X</button>
                    </div>
                </div>
                <button type="button" onclick="addTimeSlot()"
                    style="background: #3182ce; color: white; border: none; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">+
                    Add Time</button>
            </div>

            <script>
                function addTimeSlot() {
                    const container = document.getElementById('time-slots-container');
                    const div = document.createElement('div');
                    div.className = 'time-slot';
                    div.style.cssText = 'margin-bottom: 10px; display: flex; gap: 10px;';
                    div.innerHTML = `
                                <input type="time" name="times[]" required style="flex: 1;">
                                <button type="button" onclick="removeTimeSlot(this)" style="background: #e53e3e; color: white; border: none; padding: 5px 10px; border-radius: 5px;">X</button>
                            `;
                    container.appendChild(div);
                }

                function removeTimeSlot(btn) {
                    const slots = document.getElementsByClassName('time-slot');
                    if (slots.length > 1) {
                        btn.parentElement.remove();
                    } else {
                        alert('At least one time slot is required.');
                    }
                }
            </script>

            <div style="margin-top: 20px; font-size: 0.9rem; color: #666;">
                *Price will be set automatically (Weekday: 35k, Weekend: 50k).
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px;">Save Schedule</button>
        </form>
    </div>
@endsection