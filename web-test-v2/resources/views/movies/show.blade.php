@extends('layouts.app')

@section('title', $movie->title)

@section('content')
    <div class="movie-detail-container"
        style="background: white; border-radius: 12px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">

        <!-- Back Button -->
        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <a href="javascript:history.back()"
                style="text-decoration: none; font-size: 1.6rem; color: black; display: inline-flex; align-items: center; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <img src="{{ asset('back_arrow.png') }}" alt="Back" style="width: 24px; height: 24px;">
            </a>
            <h2 style="margin: 0; font-size: 1.5rem; color: var(--text-main);">Detail Film</h2>
        </div>

        <!-- Top Section: Poster & Info -->
        <div class="movie-header-detail" style="display: flex; gap: 40px; flex-wrap: wrap;">
            <a href="javascript:history.back()" style="cursor: pointer; display: block;" title="Go Back">
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
                    style="width: 250px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            </a>

            <div class="movie-info" style="flex: 1; min-width: 300px;">
                <h1 style="font-size: 2.5rem; color: var(--text-main); margin-bottom: 10px;">{{ $movie->title }}</h1>

                <div class="tags"
                    style="display: flex; gap: 15px; margin-bottom: 20px; color: var(--text-muted); font-size: 1rem;">
                    <span
                        style="background: var(--bg-secondary); padding: 5px 12px; border-radius: 20px;">{{ $movie->genre }}</span>
                    <span style="background: var(--bg-secondary); padding: 5px 12px; border-radius: 20px;">⏱
                        {{ $movie->duration }} mins</span>
                    <span style="color: var(--accent); font-weight: bold;">★ {{ $movie->rating }}</span>
                </div>

                <h3 style="font-size: 1.2rem; margin-bottom: 10px;">Synopsis</h3>
                <p style="color: var(--text-muted); line-height: 1.7; margin-bottom: 30px;">
                    {{ $movie->synopsis }}
                </p>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 40px 0;">

        @if($movie->status === 'coming_soon')
            <div class="coming-soon-notice"
                style="text-align: center; padding: 50px; background: var(--bg-secondary); border-radius: 12px; margin-top: 30px;">
                <h2 style="color: var(--text-main); margin-bottom: 10px;">Coming Soon</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem;">This film has not been shown yet.</p>
                <div style="margin-top: 20px;">
                    <a href="{{ url('/') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">&larr; Back to Movies</a>
                </div>
            </div>
        @else
            <!-- Theater Selection Section -->
            <h3 style="font-size: 1.5rem; margin-bottom: 20px;">Select Cinema</h3>

            <div class="theater-list"
                style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; margin-bottom: 30px;">
                @foreach($theaters as $theater)
                    <div class="theater-select-card" onclick="selectTheater(this, '{{ $theater->name }}', {{ $theater->id }})"
                        style="min-width: 200px; padding: 20px; border: 1px solid var(--border); border-radius: 12px; cursor: pointer; transition: 0.2s; background: white;">
                        <div style="font-weight: bold; margin-bottom: 5px;">{{ $theater->name }}</div>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $theater->city }}</div>
                    </div>
                @endforeach

                @if($theaters->isEmpty())
                    <p style="color: var(--text-muted);">No theaters currently showing this movie.</p>
                @endif
            </div>

            <!-- Schedule Section (Hidden initially) -->
            <div id="schedule-section" style="display: none; animation: fadeIn 0.5s;">
                <h3 style="font-size: 1.5rem; margin-bottom: 20px;">
                    Schedule for <span id="selected-theater-name" style="color: var(--primary);"></span>
                </h3>

                <!-- Date Selector (Dynamic) -->
                <div id="date-selector" class="date-selector" style="overflow-x: auto; padding-bottom: 10px; display: flex;">
                    <!-- JS will populate this -->
                </div>

                <!-- Time Slots -->
                <div id="time-container" style="margin-top: 20px;">
                    <!-- JS will populate this -->
                </div>
            </div>
        @endif

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 40px 0;">

        <!-- Reviews Section -->
        <h3 style="font-size: 1.5rem; margin-bottom: 20px;">Latest Reviews</h3>
        <!-- ... reviews ... -->
        <div class="reviews-list">
            @forelse($reviews as $review)
                <div class="review-card"
                    style="margin-bottom: 20px; padding: 15px; background: var(--bg-secondary); border-radius: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <strong>{{ $review->user->name }}</strong>
                        <span style="color: var(--accent);">
                            @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                        </span>
                    </div>
                    @if($review->comment)
                        <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $review->comment }}</p>
                    @else
                        <p style="color: var(--text-muted); font-size: 0.8rem; font-style: italic;">No comment provided.</p>
                    @endif
                    <small style="color: #999; font-size: 0.8rem;">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p style="color: var(--text-muted);">No reviews yet. Be the first to rate!</p>
            @endforelse
        </div>

    </div>

    <script>
        // Pass PHP data to JS
        const rawSchedules = @json($schedulesGrouped ?? []);
        let currentSchedules = {};

        function selectTheater(element, name, id) {
            // Reset Theater Cards
            document.querySelectorAll('.theater-select-card').forEach(el => {
                el.style.borderColor = 'var(--border)';
                el.style.backgroundColor = 'white';
            });

            // Highlight Selected
            element.style.borderColor = 'var(--primary)';
            element.style.backgroundColor = '#eff6ff'; // Light blue

            // Show Schedule Section
            document.getElementById('schedule-section').style.display = 'block';
            document.getElementById('selected-theater-name').textContent = name;

            // Get schedules for this theater
            // rawSchedules key is theater_id (int), so we access via id
            currentSchedules = rawSchedules[id] || {};

            renderDates(currentSchedules, id);

            // Scroll to schedule
            document.getElementById('schedule-section').scrollIntoView({ behavior: 'smooth' });
        }

        function renderDates(schedules, theaterId) {
            const dateContainer = document.getElementById('date-selector');
            const timeContainer = document.getElementById('time-container');

            dateContainer.innerHTML = '';
            timeContainer.innerHTML = '';

            const dates = Object.keys(schedules).sort();

            if (dates.length === 0) {
                dateContainer.innerHTML = '<p class="text-muted">No schedules available for this theater.</p>';
                return;
            }

            dates.forEach((dateStr, index) => {
                // Create Date Object
                const dateObj = new Date(dateStr);
                const dayName = dateObj.toLocaleDateString('en-US', { weekday: 'short' });
                const dayDate = dateObj.getDate();

                // Create Element
                const el = document.createElement('div');
                el.className = `date-card-dynamic ${index === 0 ? 'active' : ''}`;
                el.onclick = () => selectDate(el, dateStr, theaterId);
                el.style.cssText = `min-width: 80px; padding: 15px; border: 1px solid var(--border); border-radius: 10px; text-align: center; cursor: pointer; margin-right: 15px; transition: 0.2s; background: ${index === 0 ? 'var(--primary)' : 'white'}; color: ${index === 0 ? 'white' : 'var(--text-main)'}; border-color: ${index === 0 ? 'var(--primary)' : 'var(--border)'};`;

                el.innerHTML = `
                        <div style="font-size: 1.5rem; font-weight: bold;">${dayDate}</div>
                        <div style="font-size: 0.9rem; opacity: 0.8;">${dayName}</div>
                    `;

                dateContainer.appendChild(el);

                // If first date, render its times immediately
                if (index === 0) {
                    renderTimes(dateStr, theaterId);
                }
            });
        }

        function selectDate(element, dateStr, theaterId) {
            // Reset Styles
            document.querySelectorAll('.date-card-dynamic').forEach(el => {
                el.style.backgroundColor = 'white';
                el.style.color = 'var(--text-main)';
                el.style.borderColor = 'var(--border)';
            });

            // Set Active
            element.style.backgroundColor = 'var(--primary)';
            element.style.color = 'white';
            element.style.borderColor = 'var(--primary)';

            renderTimes(dateStr, theaterId);
        }

        function renderTimes(dateStr, theaterId) {
            const timeContainer = document.getElementById('time-container');
            timeContainer.innerHTML = '';

            const times = currentSchedules[dateStr] || [];

            if (times.length === 0) {
                timeContainer.innerHTML = '<p>No showtimes.</p>';
                return;
            }

            const group = document.createElement('div');
            group.style.cssText = 'display: flex; gap: 15px; flex-wrap: wrap;';

            times.forEach(slot => {
                const a = document.createElement('a');
                // Construct URL
                // params: movie_id, date, time
                // We also pass theater_id just in case, though booking.blade.php might not use it yet
                a.href = `{{ url('/booking') }}?movie_id={{ $movie->id }}&date=${dateStr}&time=${slot.time}&theater_id=${theaterId}`;
                a.className = 'time-pill';
                a.style.cssText = 'text-decoration: none; color: black; border: 1px solid var(--border); padding: 10px 25px; border-radius: 50px; transition: 0.2s; display: inline-block;';
                a.onmouseover = () => { a.style.backgroundColor = '#eff6ff'; a.style.borderColor = 'var(--primary)'; };
                a.onmouseout = () => { a.style.backgroundColor = 'white'; a.style.borderColor = 'var(--border)'; };
                a.textContent = slot.time;

                group.appendChild(a);
            });

            timeContainer.appendChild(group);
        }
    </script>
@endsection