<div class="slide-item {{ $active ? 'active' : '' }}"
    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 0.8s ease;">
    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" style="width: 100%; height: 100%; object-fit: cover;">
    <div class="slide-content"
        style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 40px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); color: white;">
        <h2 style="font-size: 2.5rem; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $movie->title }}
        </h2>
        <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
            <span
                style="background: var(--primary); padding: 5px 10px; border-radius: 5px; font-weight: bold;">{{ $movie->rating }}
                ★</span>
            <span style="font-size: 1.1rem;">{{ $movie->genre }}</span>
        </div>
        <a href="{{ route('movies.show', $movie->id) }}"
            style="display: inline-block; background: white; color: black; padding: 10px 25px; border-radius: 30px; text-decoration: none; font-weight: bold; transition: transform 0.2s;">
            Book Now
        </a>
    </div>
</div>