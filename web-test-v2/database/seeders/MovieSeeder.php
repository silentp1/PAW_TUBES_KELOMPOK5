<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder {
    public function run(): void {
        // NOW SHOWING (10 Movies)
        $nowShowing = [
            ['Tenet', 'Armed with only one word, Tenet...', 'Sci-Fi, Action', 150, 'https://image.tmdb.org/t/p/w500/k68nPLbISTUCPCDSBktg3KeOCcg.jpg', 4.8],
            ['Inception', 'A thief who steals corporate secrets...', 'Sci-Fi, Thriller', 148, 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg', 4.9],
            ['The Dark Knight', 'When the menace known as the Joker...', 'Action, Crime', 152, 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 5.0],
            ['Wonder Woman 1984', 'A botched store robbery...', 'Action, Adventure', 151, 'https://image.tmdb.org/t/p/w500/8UlWHLMpgZm9bx6QYh0NFoq67TZ.jpg', 4.2],
            ['Avatar', 'A paraplegic Marine dispatched to the moon Pandora...', 'Sci-Fi, Adventure', 162, 'https://image.tmdb.org/t/p/w500/6EiRUJzFCIIx4mGUPp1nQ1kTP1p.jpg', 4.7],
            ['Avengers: Endgame', 'After the devastating events of Infinity War...', 'Action, Sci-Fi', 181, 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 4.8],
            ['Spider-Man: No Way Home', 'Peter Parker is unmasked and no longer able to separate...', 'Action, Adventure', 148, 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg', 4.9],
            ['Black Panther', 'T\'Challa, heir to the hidden but advanced kingdom of Wakanda...', 'Action, Adventure', 134, 'https://image.tmdb.org/t/p/w500/uxzzxijgPIY7slzFvMotPv8wjKA.jpg', 4.6],
            ['Joker', 'In Gotham City, mentally troubled comedian Arthur Fleck...', 'Crime, Drama', 122, 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', 4.5],
            ['Interstellar', 'A team of explorers travel through a wormhole in space...', 'Sci-Fi, Drama', 169, 'https://image.tmdb.org/t/p/w500/gEU2QniL6C8z19uVOtY5zRKRp6we.jpg', 4.9],
        ];

        foreach ($nowShowing as $m) {
            Movie::create([
                'title' => $m[0],
                'synopsis' => $m[1],
                'genre' => $m[2],
                'duration' => $m[3],
                'poster' => $m[4],
                'rating' => $m[5],
                'status' => 'now_showing'
            ]);
        }

        // COMING SOON (6 Movies)
        $comingSoon = [
            ['Dune: Part Two', 'Paul Atreides unites with Chani...', 'Sci-Fi, Adventure', 166, 'https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg'],
            ['Mickey 17', 'Mickey 17, an "expendable"...', 'Sci-Fi, Drama', 139, 'https://image.tmdb.org/t/p/w500/52SgHOipV39F4Xb1xV9U71m5B7o.jpg'],
            ['Deadpool 3', 'Wolverine joins the "merc with a mouth"...', 'Action, Comedy', 120, 'https://image.tmdb.org/t/p/w500/yF1eOkaYvwiORauRCPWznV9xVvi.jpg'],
            ['Furiosa', 'The origin story of renegade warrior Furiosa...', 'Action, Adventure', 140, 'https://image.tmdb.org/t/p/w500/iADOJ8Zymht2JkoyFynHTihDIZC.jpg'],
            ['Despicable Me 4', 'Gru and his family return for more minion mayhem...', 'Animation, Comedy', 95, 'https://image.tmdb.org/t/p/w500/3w84hCFJATpiCO5g8hpdWVPBbmq.jpg'],
            ['Inside Out 2', 'Riley enters puberty and new emotions join the gang...', 'Animation, Family', 100, 'https://image.tmdb.org/t/p/w500/vpnVM9B6NMmQpWeZvzLvDESb2QY.jpg'],
        ];

        foreach ($comingSoon as $m) {
            Movie::create([
                'title' => $m[0],
                'synopsis' => $m[1],
                'genre' => $m[2],
                'duration' => $m[3],
                'poster' => $m[4],
                'rating' => 0,
                'status' => 'coming_soon'
            ]);
        }
    }
}
