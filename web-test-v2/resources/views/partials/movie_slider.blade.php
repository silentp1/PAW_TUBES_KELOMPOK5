<div class="movie-slider-wrapper" style="position: relative; margin-bottom: 40px;">
    <div class="section-header"
        style="margin-bottom: 20px; padding: 0 10px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: #333; font-size: 1.5rem; margin-bottom: 5px;">{{ $title }}</h2>
            @if(!empty($subtitle))
                <p style="color: #666; font-size: 0.9rem;">{{ $subtitle }}</p>
            @endif
        </div>
        <!-- See All Link -->
        <div style="font-size: 0.9rem;">
            <a href="{{ $link }}"
                style="text-decoration: none; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 5px;">
                See All <span style="font-size: 1.2rem;">&rsaquo;</span>
            </a>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <button id="prev-{{ $id }}" class="nav-btn prev-btn" style="left: 0;">
        <img src="{{ asset('arrow_back.png') }}" alt="Back" style="width: 24px; height: 24px;">
    </button>
    <button id="next-{{ $id }}" class="nav-btn next-btn" style="right: 0;">
        <img src="{{ asset('arrow_next.png') }}" alt="Next" style="width: 24px; height: 24px;">
    </button>

    <div class="slider-viewport" id="slider-{{ $id }}"
        style="overflow-x: hidden; scroll-behavior: smooth; padding: 20px 0;"> <!-- Hidden scrollbar, smooth scroll -->
        <div class="slider-track" style="display: flex; gap: 20px; width: max-content; padding: 0 10px;">
            <!-- Set 1 (Clone for Loop) -->
            @foreach($movies as $movie)
                @include('partials.movie_card', ['movie' => $movie])
            @endforeach

            <!-- Set 2 (Main) -->
            @foreach($movies as $movie)
                @include('partials.movie_card', ['movie' => $movie])
            @endforeach

            <!-- Set 3 (Clone for Loop) -->
            @foreach($movies as $movie)
                @include('partials.movie_card', ['movie' => $movie])
            @endforeach
        </div>
    </div>
</div>

<style>
    .nav-btn {
        position: absolute;
        top: 60%;
        /* Adjust based on header height + card center */
        transform: translateY(-50%);
        background: white;
        border: 1px solid #ddd;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: 0.2s;
    }

    .nav-btn:hover {
        background: #f0f0f0;
        transform: translateY(-50%) scale(1.1);
    }

    .nav-btn img {
        display: block;
    }

    /* Hide scrollbar completely */
    .slider-viewport::-webkit-scrollbar {
        display: none;
    }

    .slider-viewport {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    (function () {
        const slider = document.getElementById('slider-{{ $id }}');
        const prevBtn = document.getElementById('prev-{{ $id }}');
        const nextBtn = document.getElementById('next-{{ $id }}');

        let hasInitialized = false;
        // Width of one card (200px) + gap (20px) approx. 
        // Better to calculate dynamically if possible, but smooth scrollBy works nicely.
        const scrollAmount = 220 * 2; // Scroll 2 cards at a time

        // Infinite Scroll Logic
        function checkInfiniteScroll() {
            const totalWidth = slider.scrollWidth;
            const oneSetWidth = totalWidth / 3;

            // If scrolled to the ending buffer (Set 3), jump back to Set 2
            if (slider.scrollLeft >= 2 * oneSetWidth - 50) { // -50 buffer
                slider.style.scrollBehavior = 'auto'; // Disable smooth for instant jump
                slider.scrollLeft = slider.scrollLeft - oneSetWidth;
                setTimeout(() => { slider.style.scrollBehavior = 'smooth'; }, 50);
            }
            // If scrolled to the starting buffer (Set 1), jump forward to Set 2
            else if (slider.scrollLeft <= oneSetWidth / 2 && slider.scrollLeft < 50) {
                // Check if near 0
                // Actually relying on the center start.
                // If we go back past Set 2 start into Set 1
            }

            // Better Logic:
            // We start at Set 2.
            // If we hit Set 3 start, we snap to Set 2 start.
            // If we hit Set 1 end (going backwards), we snap to Set 2 end.

            if (slider.scrollLeft >= 2 * oneSetWidth) {
                slider.style.scrollBehavior = 'auto';
                slider.scrollLeft -= oneSetWidth;
                requestAnimationFrame(() => { slider.style.scrollBehavior = 'smooth'; });
            } else if (slider.scrollLeft <= 0) {
                slider.style.scrollBehavior = 'auto';
                slider.scrollLeft += oneSetWidth;
                requestAnimationFrame(() => { slider.style.scrollBehavior = 'smooth'; });
            }
        }

        // Initialize Center Position
        setTimeout(() => {
            const totalWidth = slider.scrollWidth;
            const oneSetWidth = totalWidth / 3;
            if (!hasInitialized && oneSetWidth > 0) {
                slider.style.scrollBehavior = 'auto';
                slider.scrollLeft = oneSetWidth; // Start at Set 2
                hasInitialized = true;
                setTimeout(() => { slider.style.scrollBehavior = 'smooth'; }, 100);
            }
        }, 300); // Increased timeout to ensure image load/layout

        slider.addEventListener('scroll', checkInfiniteScroll);

        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            // For prev, if we are at edge of Set 2/Set 1, logic inside checkInfiniteScroll handles snap?
            // Not exactly. If we scroll back and hit 0, checkInfiniteScroll snaps to Set 2 end.
            // But smooth scrolling to 0 might trigger it early?

            // Check if we are at the "start" of valid content (Set 2 start)
            const totalWidth = slider.scrollWidth;
            const oneSetWidth = totalWidth / 3;

            // Use a small threshold
            if (slider.scrollLeft <= oneSetWidth + 10) {
                // We are at start of Set 2, snap to Set 3 start instantly before scrolling back
                slider.style.scrollBehavior = 'auto';
                slider.scrollLeft += oneSetWidth; // Jump to Set 3
                // Then scroll back
                requestAnimationFrame(() => {
                    slider.style.scrollBehavior = 'smooth';
                    slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });
            } else {
                slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }
        });

        // Next Button Snap logic for safety
        nextBtn.addEventListener('mousedown', () => {
            // ensure we aren't at end
        });

    })();
</script>