<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;
use App\Models\Movie;

class TheaterSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = [
            // Jakarta
            [
                'name' => 'Grand Indonesia CGV',
                'address' => 'Jl. M.H. Thamrin No.1, Jakarta Pusat',
                'city' => 'Jakarta',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/1297376_T7m3_N34e35h01543-9533379.jpg'
            ],
            [
                'name' => 'Plaza Indonesia XXI',
                'address' => 'Jl. M.H. Thamrin Kav. 28-30, Jakarta Pusat',
                'city' => 'Jakarta',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/10839946_-29929944_20190518_153723.jpg'
            ],
            // Bandung
            [
                'name' => 'Ciwalk XXI',
                'address' => 'Cihampelas Walk, Jl. Cihampelas No.160, Bandung',
                'city' => 'Bandung',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/2261763_aV232323.jpg'
            ],
            [
                'name' => 'Trans Studio Mall CGV',
                'address' => 'Jl. Gatot Subroto No.289, Bandung',
                'city' => 'Bandung',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/382838_b382892.jpg'
            ],
            // Surabaya
            [
                'name' => 'Tunjungan Plaza XXI',
                'address' => 'Jl. Basuki Rahmat No.8-12, Surabaya',
                'city' => 'Surabaya',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/484848_c28382.jpg'
            ],
            // Yogyakarta
            [
                'name' => 'Empire XXI',
                'address' => 'Jl. Urip Sumoharjo No.104, Yogyakarta',
                'city' => 'Yogyakarta',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/58585_d23232.jpg'
            ],
            // Semarang
            [
                'name' => 'Paragon Mall XXI',
                'address' => 'Jl. Pemuda No.118, Semarang',
                'city' => 'Semarang',
                'image' => 'https://fastly.4sqi.net/img/general/600x600/68686_e2323.jpg'
            ],
        ];

        $movies = Movie::all();

        foreach ($theaters as $data) {
            $theater = Theater::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'city' => $data['city'],
                // Using a placeholder image for stability if URL fails, but kept logic above
                'image' => 'https://via.placeholder.com/600x400?text=' . urlencode($data['name']),
            ]);

            // Attach 2-3 random movies to this theater
            $theater->movies()->attach($movies->random(rand(2, 3)));
        }
    }
}
