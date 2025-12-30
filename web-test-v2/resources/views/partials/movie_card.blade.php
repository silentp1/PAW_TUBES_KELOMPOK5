<div class="movie-card-home"
    style="min-width: 200px; max-width: 200px; flex-shrink: 0; background: white; border-radius: 12px; padding: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.3s;">
    <a href="{{ route('movies.show', $movie->id) }}" style="text-decoration:none; color:inherit;">
        <div style="position: relative; overflow: hidden; border-radius: 8px; height: 280px; margin-bottom: 10px;">
            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
                style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
            <div class="hover-overlay"
                style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.3); opacity: 0; transition: 0.3s; display: flex; align-items: center; justify-content: center;">
                <span
                    style="color: white; font-weight: bold; background: var(--primary); padding: 5px 15px; border-radius: 20px;">View</span>
            </div>
        </div>

        <h3
            style="font-size: 1rem; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 5px;">
            {{ $movie->title }}
        </h3>

        <div
            style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: #888;">
            <span>{{ $movie->genre }}</span>
            <span style="color: #f5c518; font-weight: bold;">★ {{ $movie->rating }}</span>
        </div>
    </a>
</div>

@once
    <style>
        .movie-card-home:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .movie-card-home:hover img {
            transform: scale(1.1);
        }

        .movie-card-home:hover .hover-overlay {
            opacity: 1 !important;
        }
    </style>
@endonce