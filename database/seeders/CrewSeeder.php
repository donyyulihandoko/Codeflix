<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Crew;
use Illuminate\Support\Str;

class CrewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    $crews = [
        // =========================================================================
        // SUTRADARA & PENULIS INTERNASIONAL
        // =========================================================================
        [
            'name' => 'Christopher Nolan',
            'birth_date' => '1970-07-30',
            'place_of_birth' => 'London, United Kingdom',
            'biography' => 'Seorang sutradara, penulis naskah, dan produser film berkebangsaan Britania Raya dan Amerika Serikat. Dikenal lewat karya-karya ikonik berstruktur narasi kompleks seperti Inception, The Dark Knight, dan Oppenheimer.',
        ],
        [
            'name' => 'Quentin Tarantino',
            'birth_date' => '1963-03-27',
            'place_of_birth' => 'Knoxville, Tennessee, USA',
            'biography' => 'Sutradara dan penulis naskah legendaris pemenang Oscar yang terkenal dengan gaya perfilman postmodern, dialog tajam, dan estetika kekerasan yang khas seperti di Pulp Fiction dan Kill Bill.',
        ],
        [
            'name' => 'Martin Scorsese',
            'birth_date' => '1942-11-17',
            'place_of_birth' => 'Queens, New York City, USA',
            'biography' => 'Salah satu sutradara paling berpengaruh dalam sejarah sinema. Terkenal dengan eksplorasi tema identitas Katolik-Amerika, konsep kejahatan modern, dan geng kriminal seperti dalam Goodfellas, Taxi Driver, dan The Departed.',
        ],
        [
            'name' => 'James Cameron',
            'birth_date' => '1954-08-16',
            'place_of_birth' => 'Kapuskasing, Ontario, Canada',
            'biography' => 'Sutradara visioner dan pelopor teknologi CGI sinema. Ia berada di balik mahakarya berpendapatan tertinggi sepanjang masa seperti Titanic, Avatar, dan Terminator 2: Judgment Day.',
        ],
        [
            'name' => 'Steven Spielberg',
            'birth_date' => '1946-12-18',
            'place_of_birth' => 'Cincinnati, Ohio, USA',
            'biography' => 'Sutradara legendaris yang mendefinisikan era blockbuster modern Hollywood. Karya-karyanya mencakup berbagai genre mulai dari Jaws, Jurassic Park, Schindler\'s List, hingga Saving Private Ryan.',
        ],
        [
            'name' => 'Denis Villeneuve',
            'birth_date' => '1967-10-03',
            'place_of_birth' => 'Gentilly, Quebec, Canada',
            'biography' => 'Sutradara asal Kanada yang terkenal dengan visual sinematik yang megah dan atmosferik. Ia sukses menggarap film-film fiksi ilmiah modern berkelas seperti Prisoners, Arrival, Blade Runner 2049, dan seri Dune.',
        ],

        // =========================================================================
        // AKTOR & AKTRIS INTERNASIONAL
        // =========================================================================
        [
            'name' => 'Robert Downey Jr.',
            'birth_date' => '1965-04-04',
            'place_of_birth' => 'Manhattan, New York City, USA',
            'biography' => 'Aktor karismatik yang mendunia berkat perannya yang legendaris sebagai Tony Stark / Iron Man di Marvel Cinematic Universe, serta pemenang Oscar lewat perannya di film Oppenheimer.',
        ],
        [
            'name' => 'Tom Cruise',
            'birth_date' => '1962-07-03',
            'place_of_birth' => 'Syracuse, New York, USA',
            'biography' => 'Ikon film aksi global yang terkenal karena selalu melakukan aksi berbahaya (stunt) tanpa pemeran pengganti. Sangat ikonik lewat waralaba Mission: Impossible dan Top Gun.',
        ],
        [
            'name' => 'Leonardo DiCaprio',
            'birth_date' => '1974-11-11',
            'place_of_birth' => 'Los Angeles, California, USA',
            'biography' => 'Aktor watak papan atas pemenang piala Oscar yang terkenal sangat selektif dalam memilih peran. Sukses membintangi film-film raksasa seperti Titanic, Inception, The Wolf of Wall Street, dan The Revenant.',
        ],
        [
            'name' => 'Keanu Reeves',
            'birth_date' => '1964-09-02',
            'place_of_birth' => 'Beirut, Lebanon',
            'biography' => 'Aktor papan atas yang dikenal luas lewat perannya sebagai Neo di fiksi ilmiah The Matrix dan sebagai pembunuh bayaran legendaris dalam waralaba John Wick.',
        ],
        [
            'name' => 'Jason Statham',
            'birth_date' => '1967-07-26',
            'place_of_birth' => 'Shirebrook, Derbyshire, United Kingdom',
            'biography' => 'Aktor laga asal Inggris yang dikenal dengan pesona tangguh dan spesialis karakter anti-hero dalam film aksi beroktan tinggi seperti The Transporter, Crank, dan waralaba Fast & Furious.',
        ],
        [
            'name' => 'Cillian Murphy',
            'birth_date' => '1976-05-25',
            'place_of_birth' => 'Douglas, Cork, Ireland',
            'biography' => 'Aktor berbakat asal Irlandia yang terkenal lewat perannya sebagai Thomas Shelby di serial Peaky Blinders dan peraih piala Oscar sebagai J. Robert Oppenheimer dalam film Oppenheimer.',
        ],
        [
            'name' => 'Margot Robbie',
            'birth_date' => '1990-07-02',
            'place_of_birth' => 'Dalby, Australia',
            'biography' => 'Aktris dan produser Australia yang melejit lewat The Wolf of Wall Street, memerankan Harley Quinn, serta sukses besar membintangi sekaligus memproduseri film live-action Barbie.',
        ],
        [
            'name' => 'Scarlett Johansson',
            'birth_date' => '1984-11-22',
            'place_of_birth' => 'Manhattan, New York City, USA',
            'biography' => 'Aktris dengan pendapatan tertinggi di dunia selama beberapa tahun, dikenal luas secara global sebagai Natasha Romanoff / Black Widow di Marvel Cinematic Universe serta film indie berkelas seperti Marriage Story.',
        ],
        [
            'name' => 'Brad Pitt',
            'birth_date' => '1963-12-18',
            'place_of_birth' => 'Shawnee, Oklahoma, USA',
            'biography' => 'Aktor dan produser legendaris peraih piala Oscar yang menjadi salah satu figur paling berpengaruh di Hollywood. Sukses besar lewat film Fight Club, Seven, Inglourious Basterds, dan Once Upon a Time in Hollywood.',
        ],
        [
            'name' => 'Christian Bale',
            'birth_date' => '1974-01-30',
            'place_of_birth' => 'Haverfordwest, Pembrokeshire, Wales',
            'biography' => 'Aktor watak yang sangat terkenal dengan dedikasi ekstremnya melakukan transformasi fisik demi peran. Sangat ikonik sebagai Bruce Wayne/Batman di The Dark Knight Trilogy dan meraih Oscar lewat film The Fighter.',
        ],
        [
            'name' => 'Zendaya',
            'birth_date' => '1996-09-01',
            'place_of_birth' => 'Oakland, California, USA',
            'biography' => 'Aktris muda berbakat pemenang Emmy Awards yang menjadi ikon generasi baru. Menarik perhatian global melalui perannya di serial Euphoria, trilogi Spider-Man MCU, dan saga fiksi ilmiah Dune.',
        ],
        [
            'name' => 'Tom Holland',
            'birth_date' => '1996-06-01',
            'place_of_birth' => 'London, United Kingdom',
            'biography' => 'Aktor asal Inggris yang memulai karier panggungnya dalam Billy Elliot the Musical sebelum meraih ketenaran internasional sebagai Peter Parker / Spider-Man di Marvel Cinematic Universe.',
        ],

        // =========================================================================
        // SUTRADARA & PENULIS INDONESIA
        // =========================================================================
        [
            'name' => 'Joko Anwar',
            'birth_date' => '1976-01-03',
            'place_of_birth' => 'Medan, Sumatera Utara, Indonesia',
            'biography' => 'Sutradara, penulis naskah, dan produser visioner asal Indonesia. Menjadi pelopor kebangkitan sinema horor dan thriller lokal melalui karya seperti Pengabdi Setan, Kala, dan Modus Anomali.',
        ],
        [
            'name' => 'Timo Tjahjanto',
            'birth_date' => '1980-09-04',
            'place_of_birth' => 'Wilhelmshaven, Jerman',
            'biography' => 'Sutradara spesialis aksi berdarah (gore) dan horor menegangkan yang diakui internasional. Menyutradarai Sebelum Iblis Menjemput, The Night Comes for Us, dan dipercaya menggarap proyek Hollywood.',
        ],
        [
            'name' => 'Angga Dwimas Sasongko',
            'birth_date' => '1985-01-11',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Sutradara, produser, dan pendiri Visinema Pictures. Terkenal berani mengeksplorasi genre baru di Indonesia lewat film Nanti Kita Cerita Tentang Hari Ini (NKCTHI) dan film heist Mencuri Raden Saleh.',
        ],
        [
            'name' => 'Kamila Andini',
            'birth_date' => '1986-05-06',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Sutradara dan penulis naskah perempuan Indonesia yang karya-karyanya sarat dengan isu sosial, budaya, dan kesetaraan gender. Sukses meraih penghargaan internasional lewat film Yuni dan Before, Now & Then (Nana).',
        ],

        // =========================================================================
        // AKTOR & AKTRIS INDONESIA
        // =========================================================================
        [
            'name' => 'Reza Rahadian',
            'birth_date' => '1987-03-05',
            'place_of_birth' => 'Bogor, Jawa Barat, Indonesia',
            'biography' => 'Salah satu aktor watak terbaik dan terpopuler di Indonesia. Telah memenangkan berbagai penghargaan Piala Citra lewat perannya yang sangat dinamis, mulai dari Habibie & Ainun hingga My Stupid Boss.',
        ],
        [
            'name' => 'Iko Uwais',
            'birth_date' => '1983-02-12',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Aktor, koreografer pencak silat, dan bintang aksi Indonesia yang berhasil menembus industri Hollywood berkat aksi memukau di film The Raid, Merantau, dan Mile 22.',
        ],
        [
            'name' => 'Joe Taslim',
            'birth_date' => '1981-06-23',
            'place_of_birth' => 'Palembang, Sumatera Selatan, Indonesia',
            'biography' => 'Mantan atlet judo nasional yang sukses menjadi aktor laga internasional. Membintangi film-film blockbuster global seperti Fast & Furious 6, Star Trek Beyond, dan memerankan Sub-Zero di Mortal Kombat.',
        ],
        [
            'name' => 'Pevita Pearce',
            'birth_date' => '1992-10-06',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Aktris berbakat blasteran Banjar-Wales yang populer lewat film 5 cm dan Tenggelamnya Kapal Van der Wijck. Ia juga sukses memerankan pahlawan super wanita Indonesia dalam Sri Asih.',
        ],
        [
            'name' => 'Dian Sastrowardoyo',
            'birth_date' => '1982-03-16',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Aktris ikonik Indonesia yang menjadi wajah kebangkitan perfilman nasional lewat perannya sebagai Cinta di Ada Apa dengan Cinta? (AADC) dan baru-baru ini memukau lewat serial Gadis Kretek.',
        ],
        [
            'name' => 'Aghniny Haque',
            'birth_date' => '1997-03-08',
            'place_of_birth' => 'Semarang, Jawa Tengah, Indonesia',
            'biography' => 'Mantan atlet Taekwondo peringkat nasional yang sukses beralih haluan menjadi aktris laga dan horor berbakat. Sukses besar lewat film KKN di Desa Penari dan Mencuri Raden Saleh.',
        ],
        [
            'name' => 'Putri Marino',
            'birth_date' => '1993-08-04',
            'place_of_birth' => 'Denpasar, Bali, Indonesia',
            'biography' => 'Aktris berbakat peraih Piala Citra yang dikenal lewat aktingnya yang sangat natural dan penuh emosi. Melejit lewat film Posesif dan mencuri perhatian publik secara masif melalui serial Layangan Putus.',
        ],
        [
            'name' => 'Chicco Jerikho',
            'birth_date' => '1984-07-03',
            'place_of_birth' => 'Jakarta, Indonesia',
            'biography' => 'Aktor karismatik dan produser film Indonesia yang memiliki jangkauan akting luas. Terkenal melalui film Cahaya Dari Timur: Beta Maluku, Filosofi Kopi, dan Ben & Jody.',
        ],
    ];

        foreach ($crews as $crew) {
            Crew::create([
                'name' => $crew['name'],
                'slug' => Str::slug($crew['name']),
                'birth_date' => $crew['birth_date'],
                'place_of_birth' => $crew['place_of_birth'],
                'biography' => $crew['biography'],
                'photo' => null, // Dikosongkan dulu, bisa di-upload manual nanti lewat Filament
            ]);
        }
    }
}
