<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Crew;

class CrewMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil semua film dan semua kru dari database
        $movies = Movie::all();
        $crews = Crew::all();

        // Jika data masih kosong, hentikan seeder agar tidak error
        if ($movies->isEmpty() || $crews->isEmpty()) {
            return;
        }

        // 2. Kelompokkan kru berdasarkan nama mereka agar penjodohannya masuk akal
        $directors = $crews->whereIn('name', [
            'Christopher Nolan', 'Quentin Tarantino', 'Martin Scorsese',
            'James Cameron', 'Steven Spielberg', 'Denis Villeneuve',
            'Joko Anwar', 'Timo Tjahjanto', 'Angga Dwimas Sasongko', 'Kamila Andini'
        ]);

        $writers = $crews->whereIn('name', [
            'Christopher Nolan', 'Quentin Tarantino', 'Martin Scorsese',
            'Steven Spielberg', 'Denis Villeneuve', 'Joko Anwar',
            'Angga Dwimas Sasongko', 'Kamila Andini'
        ]);

        $stars = $crews->whereIn('name', [
            'Robert Downey Jr.', 'Tom Cruise', 'Leonardo DiCaprio', 'Keanu Reeves',
            'Jason Statham', 'Cillian Murphy', 'Margot Robbie', 'Scarlett Johansson',
            'Brad Pitt', 'Christian Bale', 'Zendaya', 'Tom Holland', 'Reza Rahadian',
            'Iko Uwais', 'Joe Taslim', 'Pevita Pearce', 'Dian Sastrowardoyo',
            'Aghniny Haque', 'Putri Marino', 'Chicco Jerikho'
        ]);

        // 3. Mulai jodohkan ke setiap film
        foreach ($movies as $movie) {

            // Pasangkan Sutradara (Ambil 1 atau 2 orang acak)
            $randomDirectors = $directors->random(rand(1, min(2, $directors->count())))->pluck('id')->toArray();
            $movie->directors()->sync($randomDirectors);

            // Pasangkan Penulis Naskah (Ambil 1 atau 2 orang acak)
            $randomWriters = $writers->random(rand(1, min(2, $writers->count())))->pluck('id')->toArray();
            $movie->writers()->sync($randomWriters);

            // Pasangkan Pemeran Utama/Stars (Ambil 3 sampai 5 aktor acak)
            $randomStars = $stars->random(rand(3, min(5, $stars->count())))->pluck('id')->toArray();
            $movie->stars()->sync($randomStars);
        }

    }
}
