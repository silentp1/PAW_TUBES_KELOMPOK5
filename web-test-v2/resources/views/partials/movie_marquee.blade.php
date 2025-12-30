<div class="section-container" style="margin-bottom: 40px;">
    <div class="section-header" style="margin-bottom: 20px; padding: 0 10px;">
        <h2 style="color: #333; font-size: 1.5rem; margin-bottom: 5px;">{{ $title }}</h2>
        <p style="color: #666; font-size: 0.9rem;">{{ $subtitle }}</p>
    </div>

    <div class="marquee-wrapper"
        style="overflow: hidden; position: relative; width: 100%; mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);">
        <div class="marquee-track" style="display: flex; gap: 20px; width: max-content;">

            <!-- Original Set -->
            @foreach($movies as $movie)
                @include('partials.movie_card', ['movie' => $movie])
            @endforeach

            <!-- Duplicate Set for Seamless Loop -->
            @foreach($movies as $movie)
                @include('partials.movie_card', ['movie' => $movie])
            @endforeach

        </div>
    </div>
</div>