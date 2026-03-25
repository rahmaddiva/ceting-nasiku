<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@cetingnasiku.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'Pengguna',
            'email' => 'user@cetingnasiku.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create categories
        $categories = [
            ['name' => 'MPASI 6-8 Bulan', 'slug' => 'mpasi-6-8-bulan', 'description' => 'Makanan Pendamping ASI untuk bayi usia 6-8 bulan'],
            ['name' => 'MPASI 9-11 Bulan', 'slug' => 'mpasi-9-11-bulan', 'description' => 'Makanan Pendamping ASI untuk bayi usia 9-11 bulan'],
            ['name' => 'Balita 1-3 Tahun', 'slug' => 'balita-1-3-tahun', 'description' => 'Menu sehat untuk balita usia 1-3 tahun'],
            ['name' => 'Anak 4-6 Tahun', 'slug' => 'anak-4-6-tahun', 'description' => 'Menu bergizi untuk anak usia 4-6 tahun'],
            ['name' => 'Camilan Sehat', 'slug' => 'camilan-sehat', 'description' => 'Camilan bergizi tinggi untuk anak'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create ingredients with real nutritional data (per 100g)
        $ingredientsData = [
            // ── Existing ingredients ──
            ['name' => 'Beras Putih', 'unit' => 'gram', 'calories' => 130, 'protein' => 2.7, 'fat' => 0.3, 'carbohydrates' => 28.2, 'fiber' => 0.4, 'calcium' => 10, 'iron' => 0.2, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Daging Ayam', 'unit' => 'gram', 'calories' => 239, 'protein' => 27.3, 'fat' => 13.6, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 15, 'iron' => 1.3, 'vitamin_a' => 21, 'vitamin_c' => 0],
            ['name' => 'Telur Ayam', 'unit' => 'gram', 'calories' => 155, 'protein' => 13, 'fat' => 11, 'carbohydrates' => 1.1, 'fiber' => 0, 'calcium' => 56, 'iron' => 1.8, 'vitamin_a' => 160, 'vitamin_c' => 0],
            ['name' => 'Wortel', 'unit' => 'gram', 'calories' => 41, 'protein' => 0.9, 'fat' => 0.2, 'carbohydrates' => 9.6, 'fiber' => 2.8, 'calcium' => 33, 'iron' => 0.3, 'vitamin_a' => 835, 'vitamin_c' => 5.9],
            ['name' => 'Bayam', 'unit' => 'gram', 'calories' => 23, 'protein' => 2.9, 'fat' => 0.4, 'carbohydrates' => 3.6, 'fiber' => 2.2, 'calcium' => 99, 'iron' => 2.7, 'vitamin_a' => 469, 'vitamin_c' => 28.1],
            ['name' => 'Tahu', 'unit' => 'gram', 'calories' => 76, 'protein' => 8, 'fat' => 4.8, 'carbohydrates' => 1.9, 'fiber' => 0.3, 'calcium' => 350, 'iron' => 5.4, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Tempe', 'unit' => 'gram', 'calories' => 192, 'protein' => 20.3, 'fat' => 10.8, 'carbohydrates' => 7.6, 'fiber' => 1.4, 'calcium' => 111, 'iron' => 2.7, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Ikan Salmon', 'unit' => 'gram', 'calories' => 208, 'protein' => 20.4, 'fat' => 13.4, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 12, 'iron' => 0.8, 'vitamin_a' => 40, 'vitamin_c' => 0],
            ['name' => 'Kentang', 'unit' => 'gram', 'calories' => 77, 'protein' => 2, 'fat' => 0.1, 'carbohydrates' => 17.5, 'fiber' => 2.2, 'calcium' => 12, 'iron' => 0.8, 'vitamin_a' => 2, 'vitamin_c' => 19.7],
            ['name' => 'Brokoli', 'unit' => 'gram', 'calories' => 34, 'protein' => 2.8, 'fat' => 0.4, 'carbohydrates' => 6.6, 'fiber' => 2.6, 'calcium' => 47, 'iron' => 0.7, 'vitamin_a' => 31, 'vitamin_c' => 89.2],
            ['name' => 'Pisang', 'unit' => 'gram', 'calories' => 89, 'protein' => 1.1, 'fat' => 0.3, 'carbohydrates' => 22.8, 'fiber' => 2.6, 'calcium' => 5, 'iron' => 0.3, 'vitamin_a' => 3, 'vitamin_c' => 8.7],
            ['name' => 'Alpukat', 'unit' => 'gram', 'calories' => 160, 'protein' => 2, 'fat' => 14.7, 'carbohydrates' => 8.5, 'fiber' => 6.7, 'calcium' => 12, 'iron' => 0.6, 'vitamin_a' => 7, 'vitamin_c' => 10],
            ['name' => 'Susu UHT', 'unit' => 'ml', 'calories' => 61, 'protein' => 3.2, 'fat' => 3.3, 'carbohydrates' => 4.8, 'fiber' => 0, 'calcium' => 113, 'iron' => 0, 'vitamin_a' => 46, 'vitamin_c' => 0],
            ['name' => 'Keju Cheddar', 'unit' => 'gram', 'calories' => 402, 'protein' => 25, 'fat' => 33.1, 'carbohydrates' => 1.3, 'fiber' => 0, 'calcium' => 721, 'iron' => 0.7, 'vitamin_a' => 265, 'vitamin_c' => 0],
            ['name' => 'Ubi Jalar', 'unit' => 'gram', 'calories' => 86, 'protein' => 1.6, 'fat' => 0.1, 'carbohydrates' => 20.1, 'fiber' => 3, 'calcium' => 30, 'iron' => 0.6, 'vitamin_a' => 709, 'vitamin_c' => 2.4],

            // ── New ingredients ──
            ['name' => 'Daging Sapi', 'unit' => 'gram', 'calories' => 250, 'protein' => 26, 'fat' => 15, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 18, 'iron' => 2.6, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Ikan Tuna', 'unit' => 'gram', 'calories' => 132, 'protein' => 28.2, 'fat' => 1.3, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 12, 'iron' => 1.0, 'vitamin_a' => 18, 'vitamin_c' => 0],
            ['name' => 'Hati Ayam', 'unit' => 'gram', 'calories' => 119, 'protein' => 16.9, 'fat' => 4.8, 'carbohydrates' => 0.7, 'fiber' => 0, 'calcium' => 8, 'iron' => 9.0, 'vitamin_a' => 3296, 'vitamin_c' => 17.9],
            ['name' => 'Udang', 'unit' => 'gram', 'calories' => 99, 'protein' => 24, 'fat' => 0.3, 'carbohydrates' => 0.2, 'fiber' => 0, 'calcium' => 70, 'iron' => 2.4, 'vitamin_a' => 54, 'vitamin_c' => 0],
            ['name' => 'Ikan Lele', 'unit' => 'gram', 'calories' => 105, 'protein' => 18.2, 'fat' => 2.9, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 14, 'iron' => 0.3, 'vitamin_a' => 10, 'vitamin_c' => 0.7],
            ['name' => 'Labu Kuning', 'unit' => 'gram', 'calories' => 26, 'protein' => 1.0, 'fat' => 0.1, 'carbohydrates' => 6.5, 'fiber' => 0.5, 'calcium' => 21, 'iron' => 0.8, 'vitamin_a' => 426, 'vitamin_c' => 9.0],
            ['name' => 'Jagung Manis', 'unit' => 'gram', 'calories' => 86, 'protein' => 3.3, 'fat' => 1.4, 'carbohydrates' => 19, 'fiber' => 2.7, 'calcium' => 2, 'iron' => 0.5, 'vitamin_a' => 9, 'vitamin_c' => 6.8],
            ['name' => 'Kacang Hijau', 'unit' => 'gram', 'calories' => 347, 'protein' => 23.9, 'fat' => 1.2, 'carbohydrates' => 62.6, 'fiber' => 16.3, 'calcium' => 132, 'iron' => 6.7, 'vitamin_a' => 6, 'vitamin_c' => 4.8],
            ['name' => 'Edamame', 'unit' => 'gram', 'calories' => 121, 'protein' => 11.9, 'fat' => 5.2, 'carbohydrates' => 8.9, 'fiber' => 5.2, 'calcium' => 63, 'iron' => 2.3, 'vitamin_a' => 15, 'vitamin_c' => 6.1],
            ['name' => 'Tomat', 'unit' => 'gram', 'calories' => 18, 'protein' => 0.9, 'fat' => 0.2, 'carbohydrates' => 3.9, 'fiber' => 1.2, 'calcium' => 10, 'iron' => 0.3, 'vitamin_a' => 42, 'vitamin_c' => 13.7],
            ['name' => 'Pepaya', 'unit' => 'gram', 'calories' => 43, 'protein' => 0.5, 'fat' => 0.3, 'carbohydrates' => 10.8, 'fiber' => 1.7, 'calcium' => 20, 'iron' => 0.3, 'vitamin_a' => 47, 'vitamin_c' => 60.9],
            ['name' => 'Mangga', 'unit' => 'gram', 'calories' => 60, 'protein' => 0.8, 'fat' => 0.4, 'carbohydrates' => 15, 'fiber' => 1.6, 'calcium' => 11, 'iron' => 0.2, 'vitamin_a' => 54, 'vitamin_c' => 36.4],
            ['name' => 'Oat (Havermut)', 'unit' => 'gram', 'calories' => 389, 'protein' => 16.9, 'fat' => 6.9, 'carbohydrates' => 66.3, 'fiber' => 10.6, 'calcium' => 54, 'iron' => 4.7, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Santan', 'unit' => 'ml', 'calories' => 230, 'protein' => 2.3, 'fat' => 23.8, 'carbohydrates' => 5.5, 'fiber' => 0, 'calcium' => 16, 'iron' => 1.6, 'vitamin_a' => 0, 'vitamin_c' => 2.8],
            ['name' => 'Minyak Zaitun', 'unit' => 'ml', 'calories' => 884, 'protein' => 0, 'fat' => 100, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 1, 'iron' => 0.6, 'vitamin_a' => 0, 'vitamin_c' => 0],

            // ── Bahan lokal pedesaan Indonesia ──
            ['name' => 'Daun Kelor', 'unit' => 'gram', 'calories' => 64, 'protein' => 9.4, 'fat' => 1.4, 'carbohydrates' => 8.3, 'fiber' => 2.0, 'calcium' => 185, 'iron' => 4.0, 'vitamin_a' => 378, 'vitamin_c' => 51.7],
            ['name' => 'Kangkung', 'unit' => 'gram', 'calories' => 19, 'protein' => 2.6, 'fat' => 0.2, 'carbohydrates' => 3.1, 'fiber' => 2.1, 'calcium' => 77, 'iron' => 1.7, 'vitamin_a' => 315, 'vitamin_c' => 55],
            ['name' => 'Ikan Teri', 'unit' => 'gram', 'calories' => 77, 'protein' => 16, 'fat' => 1.0, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 1209, 'iron' => 3.3, 'vitamin_a' => 15, 'vitamin_c' => 0],
            ['name' => 'Singkong', 'unit' => 'gram', 'calories' => 160, 'protein' => 1.4, 'fat' => 0.3, 'carbohydrates' => 38.1, 'fiber' => 1.8, 'calcium' => 16, 'iron' => 0.3, 'vitamin_a' => 1, 'vitamin_c' => 20.6],
            ['name' => 'Kelapa Parut', 'unit' => 'gram', 'calories' => 354, 'protein' => 3.3, 'fat' => 33.5, 'carbohydrates' => 15.2, 'fiber' => 9.0, 'calcium' => 14, 'iron' => 2.4, 'vitamin_a' => 0, 'vitamin_c' => 3.3],
            ['name' => 'Kacang Tanah', 'unit' => 'gram', 'calories' => 567, 'protein' => 25.8, 'fat' => 49.2, 'carbohydrates' => 16.1, 'fiber' => 8.5, 'calcium' => 92, 'iron' => 4.6, 'vitamin_a' => 0, 'vitamin_c' => 0],
            ['name' => 'Daun Singkong', 'unit' => 'gram', 'calories' => 91, 'protein' => 6.8, 'fat' => 1.2, 'carbohydrates' => 13.0, 'fiber' => 1.9, 'calcium' => 165, 'iron' => 2.0, 'vitamin_a' => 275, 'vitamin_c' => 60],
            ['name' => 'Nangka Muda', 'unit' => 'gram', 'calories' => 52, 'protein' => 2.0, 'fat' => 0.3, 'carbohydrates' => 11.4, 'fiber' => 1.5, 'calcium' => 45, 'iron' => 0.6, 'vitamin_a' => 25, 'vitamin_c' => 9],
            ['name' => 'Terong', 'unit' => 'gram', 'calories' => 25, 'protein' => 1.0, 'fat' => 0.2, 'carbohydrates' => 5.9, 'fiber' => 3.0, 'calcium' => 9, 'iron' => 0.2, 'vitamin_a' => 1, 'vitamin_c' => 2.2],
            ['name' => 'Ikan Nila', 'unit' => 'gram', 'calories' => 96, 'protein' => 20.1, 'fat' => 1.7, 'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 10, 'iron' => 0.6, 'vitamin_a' => 0, 'vitamin_c' => 0],
        ];

        $ingredients = [];
        foreach ($ingredientsData as $ing) {
            $ingredients[$ing['name']] = Ingredient::create($ing);
        }

        // =====================================================================
        // RECIPES
        // =====================================================================

        // ── Category 1: MPASI 6-8 Bulan ──

        $recipe1 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 1,
            'title' => 'Bubur Ayam Wortel',
            'slug' => 'bubur-ayam-wortel',
            'description' => 'Bubur lembut dengan campuran ayam dan wortel yang kaya akan protein dan vitamin A, cocok untuk MPASI bayi 6-8 bulan.',
            'instructions' => "1. Cuci beras dan rendam selama 30 menit\n2. Rebus ayam hingga matang, suwir halus\n3. Kupas dan potong wortel kecil-kecil\n4. Masak beras dengan air hingga menjadi bubur\n5. Tambahkan ayam suwir dan wortel\n6. Masak hingga semua bahan lunak\n7. Blender hingga halus sesuai tekstur yang diinginkan\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);
        $recipe1->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 30],
            $ingredients['Daging Ayam']->id => ['quantity_grams' => 25],
            $ingredients['Wortel']->id => ['quantity_grams' => 20],
        ]);

        $recipe2 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 1,
            'title' => 'Puree Labu Kuning Hati Ayam',
            'slug' => 'puree-labu-kuning-hati-ayam',
            'description' => 'Puree lembut labu kuning dan hati ayam yang sangat kaya zat besi dan vitamin A, ideal untuk mencegah anemia pada bayi.',
            'instructions' => "1. Cuci labu kuning, kupas dan potong dadu kecil\n2. Cuci hati ayam, buang bagian yang keras\n3. Kukus labu kuning dan hati ayam selama 15 menit hingga empuk\n4. Masukkan ke dalam blender bersama sedikit air matang\n5. Blender hingga menjadi puree halus\n6. Tambahkan setetes minyak zaitun untuk lemak sehat\n7. Aduk rata dan sajikan hangat",
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);
        $recipe2->ingredients()->attach([
            $ingredients['Labu Kuning']->id => ['quantity_grams' => 50],
            $ingredients['Hati Ayam']->id => ['quantity_grams' => 20],
            $ingredients['Minyak Zaitun']->id => ['quantity_grams' => 3],
        ]);

        $recipe3 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 1,
            'title' => 'Puree Bayam Tahu',
            'slug' => 'puree-bayam-tahu',
            'description' => 'Puree bayam dan tahu yang lembut, kaya kalsium dan zat besi untuk pertumbuhan tulang dan mencegah stunting.',
            'instructions' => "1. Cuci bayam segar, petik daunnya\n2. Potong tahu menjadi potongan kecil\n3. Rebus beras dengan air hingga menjadi bubur lembek\n4. Kukus bayam dan tahu selama 10 menit\n5. Campurkan semua bahan ke dalam blender\n6. Blender hingga halus, tambahkan air matang jika terlalu kental\n7. Sajikan hangat dengan tekstur sesuai usia bayi",
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);
        $recipe3->ingredients()->attach([
            $ingredients['Bayam']->id => ['quantity_grams' => 25],
            $ingredients['Tahu']->id => ['quantity_grams' => 30],
            $ingredients['Beras Putih']->id => ['quantity_grams' => 25],
        ]);

        // ── Category 2: MPASI 9-11 Bulan ──

        $recipe4 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 2,
            'title' => 'Bubur Nasi Tim Telur Bayam',
            'slug' => 'bubur-nasi-tim-telur-bayam',
            'description' => 'Nasi tim lembut dengan telur dan bayam, tinggi protein dan zat besi untuk bayi yang mulai belajar mengunyah.',
            'instructions' => "1. Masak beras dengan air agak banyak hingga menjadi nasi lembek\n2. Kocok telur ayam, buat telur orak-arik lembut\n3. Cuci bayam, potong halus\n4. Campurkan nasi lembek, telur orak-arik, dan bayam\n5. Tim dalam panci kukusan selama 15 menit\n6. Hancurkan kasar dengan garpu (tekstur lebih kasar dari puree)\n7. Tambahkan sedikit wortel parut untuk variasi\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'is_published' => true,
        ]);
        $recipe4->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 40],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 30],
            $ingredients['Bayam']->id => ['quantity_grams' => 20],
            $ingredients['Wortel']->id => ['quantity_grams' => 15],
        ]);

        $recipe5 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 2,
            'title' => 'Sup Ikan Tuna Kentang',
            'slug' => 'sup-ikan-tuna-kentang',
            'description' => 'Sup lembut dengan ikan tuna yang kaya protein tinggi dan kentang sebagai sumber karbohidrat, dilengkapi sayuran bergizi.',
            'instructions' => "1. Kukus ikan tuna hingga matang, hancurkan dengan garpu\n2. Kupas kentang dan potong dadu kecil\n3. Potong wortel dan brokoli kecil-kecil\n4. Rebus kentang dan wortel dalam air hingga empuk\n5. Tambahkan brokoli, masak 5 menit lagi\n6. Masukkan tuna yang sudah dihancurkan\n7. Aduk rata, haluskan sebagian jika perlu\n8. Sajikan hangat sebagai sup lembut",
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'is_published' => true,
        ]);
        $recipe5->ingredients()->attach([
            $ingredients['Ikan Tuna']->id => ['quantity_grams' => 30],
            $ingredients['Kentang']->id => ['quantity_grams' => 40],
            $ingredients['Wortel']->id => ['quantity_grams' => 20],
            $ingredients['Brokoli']->id => ['quantity_grams' => 15],
        ]);

        $recipe6 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 2,
            'title' => 'Bubur Kacang Hijau Labu',
            'slug' => 'bubur-kacang-hijau-labu',
            'description' => 'Bubur kacang hijau lembut dengan labu kuning, kaya serat, protein nabati, dan vitamin A untuk daya tahan tubuh bayi.',
            'instructions' => "1. Rendam kacang hijau selama 2 jam, lalu cuci bersih\n2. Kupas labu kuning, potong dadu kecil\n3. Rebus kacang hijau dengan air hingga lunak (sekitar 30 menit)\n4. Tambahkan labu kuning, masak hingga empuk\n5. Tambahkan santan encer, aduk rata\n6. Masak 5 menit lagi dengan api kecil\n7. Haluskan sebagian agar tekstur lembut tapi masih ada butiran\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'is_published' => true,
        ]);
        $recipe6->ingredients()->attach([
            $ingredients['Kacang Hijau']->id => ['quantity_grams' => 30],
            $ingredients['Labu Kuning']->id => ['quantity_grams' => 40],
            $ingredients['Santan']->id => ['quantity_grams' => 20],
        ]);

        // ── Category 3: Balita 1-3 Tahun ──

        $recipe7 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 3,
            'title' => 'Nasi Tim Salmon Brokoli',
            'slug' => 'nasi-tim-salmon-brokoli',
            'description' => 'Nasi tim lembut dengan salmon kaya omega-3 dan brokoli sumber vitamin C, sempurna untuk tumbuh kembang balita.',
            'instructions' => "1. Cuci beras dan masak menjadi nasi yang agak lembek\n2. Kukus salmon hingga matang, hancurkan dengan garpu\n3. Potong brokoli kecil-kecil, kukus hingga lunak\n4. Campurkan nasi, salmon, dan brokoli\n5. Tim selama 15 menit agar semua bahan menyatu\n6. Tambahkan sedikit keju parut sebagai penambah rasa\n7. Sajikan hangat",
            'servings' => 2,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe7->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 80],
            $ingredients['Ikan Salmon']->id => ['quantity_grams' => 40],
            $ingredients['Brokoli']->id => ['quantity_grams' => 30],
            $ingredients['Keju Cheddar']->id => ['quantity_grams' => 10],
        ]);

        $recipe8 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 3,
            'title' => 'Nasi Goreng Telur Sayuran',
            'slug' => 'nasi-goreng-telur-sayuran',
            'description' => 'Nasi goreng sederhana tanpa MSG dengan telur dan sayuran segar, sumber protein dan serat yang disukai balita.',
            'instructions' => "1. Masak nasi dan biarkan agak dingin\n2. Kocok telur, buat orak-arik lembut di wajan\n3. Potong wortel menjadi dadu kecil, rebus sebentar hingga setengah matang\n4. Pipil jagung manis dari tongkolnya\n5. Panaskan sedikit minyak, tumis wortel dan jagung\n6. Masukkan nasi, aduk rata\n7. Tambahkan telur orak-arik, aduk hingga tercampur merata\n8. Masak dengan api sedang selama 3-5 menit\n9. Sajikan hangat",
            'servings' => 2,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe8->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 100],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 50],
            $ingredients['Wortel']->id => ['quantity_grams' => 25],
            $ingredients['Jagung Manis']->id => ['quantity_grams' => 30],
        ]);

        $recipe9 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 3,
            'title' => 'Perkedel Kentang Daging',
            'slug' => 'perkedel-kentang-daging',
            'description' => 'Perkedel kentang isi daging sapi cincang yang lembut, tinggi protein dan karbohidrat untuk energi bermain balita.',
            'instructions' => "1. Kupas kentang, potong-potong lalu rebus hingga empuk\n2. Daging sapi cincang halus, tumis hingga matang\n3. Parut wortel, campurkan ke daging tumis\n4. Haluskan kentang rebus dengan garpu\n5. Campurkan kentang halus, daging tumis, dan wortel\n6. Kocok telur, gunakan sebagian sebagai campuran adonan\n7. Bentuk adonan bulat pipih\n8. Celupkan ke sisa kocokan telur\n9. Goreng dengan sedikit minyak hingga keemasan\n10. Tiriskan dan sajikan hangat",
            'servings' => 4,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe9->ingredients()->attach([
            $ingredients['Kentang']->id => ['quantity_grams' => 150],
            $ingredients['Daging Sapi']->id => ['quantity_grams' => 50],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 50],
            $ingredients['Wortel']->id => ['quantity_grams' => 30],
        ]);

        // ── Category 4: Anak 4-6 Tahun ──

        $recipe10 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Soto Ayam Bening',
            'slug' => 'soto-ayam-bening',
            'description' => 'Soto ayam bening yang hangat dan bergizi, kaya protein dari ayam dan telur, dilengkapi sayuran untuk serat harian anak.',
            'instructions' => "1. Rebus daging ayam dengan air secukupnya hingga matang\n2. Angkat ayam, suwir-suwir dagingnya\n3. Kupas kentang, potong dadu, rebus di kuah ayam\n4. Potong wortel tipis, tambahkan ke kuah\n5. Rebus telur hingga matang, kupas dan belah dua\n6. Masak hingga semua sayuran empuk\n7. Tata nasi di mangkuk, siram dengan kuah soto\n8. Taburi ayam suwir, kentang, wortel, dan telur rebus\n9. Sajikan hangat",
            'servings' => 3,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe10->ingredients()->attach([
            $ingredients['Daging Ayam']->id => ['quantity_grams' => 80],
            $ingredients['Kentang']->id => ['quantity_grams' => 60],
            $ingredients['Wortel']->id => ['quantity_grams' => 40],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 50],
            $ingredients['Beras Putih']->id => ['quantity_grams' => 120],
        ]);

        $recipe11 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Tumis Tempe Jagung Manis',
            'slug' => 'tumis-tempe-jagung-manis',
            'description' => 'Tumis tempe dengan jagung manis dan sayuran, sumber protein nabati dan serat yang lezat untuk makan siang anak.',
            'instructions' => "1. Potong tempe menjadi dadu kecil\n2. Pipil jagung manis dari tongkolnya\n3. Potong wortel kecil-kecil, potong brokoli per kuntum kecil\n4. Panaskan sedikit minyak, goreng tempe hingga kuning keemasan\n5. Tumis wortel hingga setengah matang\n6. Tambahkan jagung dan brokoli, aduk rata\n7. Masukkan kembali tempe goreng\n8. Tambahkan sedikit air dan kecap manis\n9. Masak hingga semua sayuran matang\n10. Sajikan dengan nasi hangat",
            'servings' => 3,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe11->ingredients()->attach([
            $ingredients['Tempe']->id => ['quantity_grams' => 100],
            $ingredients['Jagung Manis']->id => ['quantity_grams' => 60],
            $ingredients['Wortel']->id => ['quantity_grams' => 30],
            $ingredients['Brokoli']->id => ['quantity_grams' => 30],
        ]);

        $recipe12 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Nasi Uduk Telur Tempe',
            'slug' => 'nasi-uduk-telur-tempe',
            'description' => 'Nasi uduk gurih dengan lauk telur dan tempe goreng, menu klasik Indonesia yang kaya energi dan protein untuk anak aktif.',
            'instructions' => "1. Cuci beras, masak bersama santan dan sedikit garam hingga menjadi nasi uduk\n2. Rebus telur hingga matang, kupas dan goreng sebentar\n3. Iris tempe tipis, goreng hingga kuning keemasan\n4. Potong tomat segar untuk pelengkap\n5. Tata nasi uduk di piring\n6. Sajikan dengan telur, tempe goreng, dan irisan tomat\n7. Tambahkan irisan timun jika suka",
            'servings' => 3,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe12->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 150],
            $ingredients['Santan']->id => ['quantity_grams' => 50],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 100],
            $ingredients['Tempe']->id => ['quantity_grams' => 80],
            $ingredients['Tomat']->id => ['quantity_grams' => 30],
        ]);

        // ── Category 5: Camilan Sehat ──

        $recipe13 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 5,
            'title' => 'Smoothie Pisang Alpukat',
            'slug' => 'smoothie-pisang-alpukat',
            'description' => 'Smoothie creamy dan bergizi dari campuran pisang dan alpukat, kaya akan serat, kalium, dan lemak sehat untuk energi anak.',
            'instructions' => "1. Kupas pisang dan potong-potong\n2. Ambil daging alpukat\n3. Masukkan pisang dan alpukat ke dalam blender\n4. Tambahkan susu UHT\n5. Blender hingga halus dan creamy\n6. Tuang ke gelas dan sajikan segera",
            'servings' => 1,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe13->ingredients()->attach([
            $ingredients['Pisang']->id => ['quantity_grams' => 100],
            $ingredients['Alpukat']->id => ['quantity_grams' => 50],
            $ingredients['Susu UHT']->id => ['quantity_grams' => 100],
        ]);

        $recipe14 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 5,
            'title' => 'Pancake Oat Pisang',
            'slug' => 'pancake-oat-pisang',
            'description' => 'Pancake sehat dari oat dan pisang tanpa gula tambahan, tinggi serat dan protein baik untuk camilan bergizi anak.',
            'instructions' => "1. Haluskan pisang dengan garpu di mangkuk\n2. Tambahkan oat (havermut) dan aduk rata\n3. Kocok telur, campurkan ke adonan\n4. Tambahkan susu UHT, aduk hingga adonan tercampur rata\n5. Panaskan wajan anti lengket dengan sedikit minyak\n6. Tuang satu sendok sayur adonan, ratakan\n7. Masak dengan api kecil hingga sisi bawah keemasan\n8. Balik dan masak sisi lainnya\n9. Ulangi hingga adonan habis\n10. Sajikan dengan potongan buah segar",
            'servings' => 3,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe14->ingredients()->attach([
            $ingredients['Oat (Havermut)']->id => ['quantity_grams' => 50],
            $ingredients['Pisang']->id => ['quantity_grams' => 80],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 50],
            $ingredients['Susu UHT']->id => ['quantity_grams' => 50],
        ]);

        $recipe15 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 5,
            'title' => 'Puding Mangga Susu',
            'slug' => 'puding-mangga-susu',
            'description' => 'Puding mangga susu yang segar dan lembut, kaya vitamin C dan kalsium, camilan favorit yang menyehatkan untuk anak.',
            'instructions' => "1. Kupas mangga matang, potong dadu\n2. Blender setengah bagian mangga hingga halus untuk saus\n3. Kukus ubi jalar hingga empuk, haluskan\n4. Panaskan susu UHT, campurkan ubi jalar halus\n5. Aduk rata hingga mengental seperti puding\n6. Tuang ke cetakan, diamkan hingga set\n7. Masukkan potongan mangga segar di atas puding\n8. Siram dengan saus mangga\n9. Dinginkan di kulkas 1-2 jam\n10. Sajikan dingin",
            'servings' => 3,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe15->ingredients()->attach([
            $ingredients['Mangga']->id => ['quantity_grams' => 100],
            $ingredients['Susu UHT']->id => ['quantity_grams' => 150],
            $ingredients['Ubi Jalar']->id => ['quantity_grams' => 60],
        ]);

        // =====================================================================
        // RESEP LOKAL PEDESAAN INDONESIA
        // =====================================================================

        // ── Category 1: MPASI 6-8 Bulan (Lokal) ──

        $recipe16 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 1,
            'title' => 'Bubur Daun Kelor Ikan Teri',
            'slug' => 'bubur-daun-kelor-ikan-teri',
            'description' => 'Bubur MPASI super bergizi dari daun kelor dan ikan teri, dua bahan lokal pedesaan yang sangat kaya kalsium, zat besi, dan vitamin A untuk mencegah stunting.',
            'instructions' => "1. Cuci daun kelor, petik daunnya dari tangkainya\n2. Rendam ikan teri kecil dalam air hangat, buang kepalanya\n3. Masak beras dengan air hingga menjadi bubur lembut\n4. Kukus daun kelor selama 5 menit\n5. Haluskan ikan teri yang sudah direndam\n6. Campurkan daun kelor dan ikan teri ke dalam bubur\n7. Blender hingga halus sesuai tekstur bayi\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);
        $recipe16->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 25],
            $ingredients['Daun Kelor']->id => ['quantity_grams' => 15],
            $ingredients['Ikan Teri']->id => ['quantity_grams' => 10],
        ]);

        $recipe17 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 1,
            'title' => 'Puree Ubi Jalar Kangkung',
            'slug' => 'puree-ubi-jalar-kangkung',
            'description' => 'Puree manis alami dari ubi jalar dan kangkung yang mudah didapat di pekarangan, kaya vitamin A dan zat besi.',
            'instructions' => "1. Cuci ubi jalar, kupas dan potong kecil-kecil\n2. Cuci kangkung, petik daun mudanya saja\n3. Kukus ubi jalar hingga empuk (sekitar 15 menit)\n4. Kukus kangkung selama 5 menit\n5. Masukkan ubi jalar dan kangkung ke blender\n6. Tambahkan sedikit air matang\n7. Blender hingga halus sempurna\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);
        $recipe17->ingredients()->attach([
            $ingredients['Ubi Jalar']->id => ['quantity_grams' => 50],
            $ingredients['Kangkung']->id => ['quantity_grams' => 20],
        ]);

        // ── Category 2: MPASI 9-11 Bulan (Lokal) ──

        $recipe18 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 2,
            'title' => 'Nasi Tim Ikan Nila Bayam',
            'slug' => 'nasi-tim-ikan-nila-bayam',
            'description' => 'Nasi tim dengan ikan nila segar dari tambak desa dan bayam kebun, sumber protein dan zat besi yang mudah dijangkau.',
            'instructions' => "1. Masak beras hingga menjadi nasi lembek\n2. Kukus ikan nila hingga matang, buang duri dengan hati-hati\n3. Hancurkan daging ikan nila dengan garpu\n4. Cuci bayam, potong halus\n5. Campurkan nasi, ikan nila, dan bayam\n6. Tim selama 15 menit\n7. Hancurkan kasar dengan garpu\n8. Sajikan hangat",
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'is_published' => true,
        ]);
        $recipe18->ingredients()->attach([
            $ingredients['Beras Putih']->id => ['quantity_grams' => 40],
            $ingredients['Ikan Nila']->id => ['quantity_grams' => 30],
            $ingredients['Bayam']->id => ['quantity_grams' => 20],
        ]);

        $recipe19 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 2,
            'title' => 'Bubur Singkong Daun Kelor Telur',
            'slug' => 'bubur-singkong-daun-kelor-telur',
            'description' => 'Bubur dari singkong lokal dengan daun kelor dan telur kampung, kombinasi superfood desa yang kaya nutrisi lengkap.',
            'instructions' => "1. Kupas singkong, cuci dan parut halus\n2. Petik daun kelor dari tangkainya, cuci bersih\n3. Rebus singkong parut dengan air hingga lembut\n4. Kocok telur, masukkan ke rebusan singkong sambil diaduk\n5. Tambahkan daun kelor, masak 5 menit lagi\n6. Haluskan dengan garpu (tekstur kasar)\n7. Sajikan hangat",
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'is_published' => true,
        ]);
        $recipe19->ingredients()->attach([
            $ingredients['Singkong']->id => ['quantity_grams' => 50],
            $ingredients['Daun Kelor']->id => ['quantity_grams' => 15],
            $ingredients['Telur Ayam']->id => ['quantity_grams' => 30],
        ]);

        // ── Category 3: Balita 1-3 Tahun (Lokal) ──

        $recipe20 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 3,
            'title' => 'Sayur Bening Bayam Jagung',
            'slug' => 'sayur-bening-bayam-jagung',
            'description' => 'Sayur bening khas desa dengan bayam dan jagung manis segar dari kebun, ringan bergizi dan disukai anak-anak.',
            'instructions' => "1. Pipil jagung manis dari tongkolnya\n2. Cuci bayam segar, petik daunnya\n3. Didihkan air dalam panci\n4. Masukkan jagung terlebih dahulu, masak 10 menit\n5. Tambahkan bayam, masak 3 menit saja agar tetap hijau\n6. Beri sedikit garam\n7. Sajikan hangat dengan nasi putih",
            'servings' => 3,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe20->ingredients()->attach([
            $ingredients['Bayam']->id => ['quantity_grams' => 50],
            $ingredients['Jagung Manis']->id => ['quantity_grams' => 80],
            $ingredients['Beras Putih']->id => ['quantity_grams' => 80],
        ]);

        $recipe21 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 3,
            'title' => 'Pepes Ikan Lele Kemangi',
            'slug' => 'pepes-ikan-lele-kemangi',
            'description' => 'Pepes ikan lele dibungkus daun pisang khas masakan desa, lembut dan harum dengan protein tinggi dari ikan kolam.',
            'instructions' => "1. Bersihkan ikan lele, buang isi perut dan insangnya\n2. Lumuri ikan dengan sedikit garam dan perasan jeruk nipis\n3. Iris tomat tipis-tipis\n4. Siapkan daun pisang untuk membungkus\n5. Letakkan ikan di atas daun pisang\n6. Tambahkan irisan tomat di atas ikan\n7. Bungkus rapi dan semat dengan lidi\n8. Kukus selama 25-30 menit hingga matang\n9. Sajikan hangat dengan nasi",
            'servings' => 2,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe21->ingredients()->attach([
            $ingredients['Ikan Lele']->id => ['quantity_grams' => 100],
            $ingredients['Tomat']->id => ['quantity_grams' => 30],
        ]);

        // ── Category 4: Anak 4-6 Tahun (Lokal) ──

        $recipe22 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Sayur Lodeh Nangka Muda',
            'slug' => 'sayur-lodeh-nangka-muda',
            'description' => 'Sayur lodeh nangka muda dengan santan khas masakan Jawa pedesaan, gurih dan kaya serat serta kalsium.',
            'instructions' => "1. Kupas nangka muda, potong dadu, rendam air garam agar getahnya hilang\n2. Potong terong memanjang\n3. Pipil jagung manis dari tongkol\n4. Didihkan santan encer dengan sedikit garam\n5. Masukkan nangka muda terlebih dahulu, masak 15 menit\n6. Tambahkan terong dan jagung\n7. Masak dengan api kecil hingga semua bahan empuk\n8. Koreksi rasa, sajikan hangat dengan nasi",
            'servings' => 4,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe22->ingredients()->attach([
            $ingredients['Nangka Muda']->id => ['quantity_grams' => 80],
            $ingredients['Terong']->id => ['quantity_grams' => 50],
            $ingredients['Jagung Manis']->id => ['quantity_grams' => 50],
            $ingredients['Santan']->id => ['quantity_grams' => 100],
        ]);

        $recipe23 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Urap Sayur Kelapa',
            'slug' => 'urap-sayur-kelapa',
            'description' => 'Urap sayuran segar dengan bumbu kelapa parut khas Jawa, cara tradisional makan sayur yang disukai anak-anak desa.',
            'instructions' => "1. Cuci kangkung, petik daun dan batang mudanya\n2. Cuci bayam, petik daunnya\n3. Parut kelapa segar\n4. Rebus kangkung dan bayam terpisah, tiriskan\n5. Sangrai kelapa parut dengan sedikit garam hingga harum\n6. Campurkan sayuran rebus dengan kelapa parut sangrai\n7. Aduk rata hingga semua sayur terbalut kelapa\n8. Sajikan sebagai lauk pendamping nasi",
            'servings' => 3,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe23->ingredients()->attach([
            $ingredients['Kangkung']->id => ['quantity_grams' => 60],
            $ingredients['Bayam']->id => ['quantity_grams' => 40],
            $ingredients['Kelapa Parut']->id => ['quantity_grams' => 50],
        ]);

        $recipe24 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 4,
            'title' => 'Gulai Daun Singkong Ikan Teri',
            'slug' => 'gulai-daun-singkong-ikan-teri',
            'description' => 'Gulai daun singkong dengan ikan teri khas Minang pedesaan, sangat kaya kalsium, protein, dan zat besi untuk pertumbuhan anak.',
            'instructions' => "1. Petik daun singkong muda, remas dengan sedikit garam agar empuk\n2. Cuci ikan teri, rendam sebentar\n3. Didihkan santan encer\n4. Masukkan daun singkong, masak 20 menit hingga layu dan empuk\n5. Tambahkan ikan teri, aduk rata\n6. Masak dengan api kecil hingga kuah mengental\n7. Koreksi rasa dengan sedikit garam\n8. Sajikan hangat dengan nasi putih",
            'servings' => 4,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe24->ingredients()->attach([
            $ingredients['Daun Singkong']->id => ['quantity_grams' => 100],
            $ingredients['Ikan Teri']->id => ['quantity_grams' => 30],
            $ingredients['Santan']->id => ['quantity_grams' => 80],
        ]);

        // ── Category 5: Camilan Sehat (Lokal) ──

        $recipe25 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 5,
            'title' => 'Kolak Pisang Ubi',
            'slug' => 'kolak-pisang-ubi',
            'description' => 'Kolak pisang dan ubi jalar dengan santan, camilan tradisional Indonesia yang hangat, manis alami, dan kaya energi.',
            'instructions' => "1. Kupas pisang, potong menjadi beberapa bagian\n2. Kupas ubi jalar, potong dadu\n3. Didihkan santan dengan sedikit gula aren\n4. Masukkan ubi jalar terlebih dahulu, masak 10 menit\n5. Tambahkan potongan pisang\n6. Masak 5-7 menit lagi hingga pisang empuk tapi tidak hancur\n7. Sajikan hangat dalam mangkuk",
            'servings' => 3,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);
        $recipe25->ingredients()->attach([
            $ingredients['Pisang']->id => ['quantity_grams' => 100],
            $ingredients['Ubi Jalar']->id => ['quantity_grams' => 80],
            $ingredients['Santan']->id => ['quantity_grams' => 100],
        ]);

        $recipe26 = Recipe::create([
            'user_id' => $admin->id,
            'category_id' => 5,
            'title' => 'Singkong Rebus Urap Kacang',
            'slug' => 'singkong-rebus-urap-kacang',
            'description' => 'Singkong rebus dengan taburan bumbu kacang tanah sangrai, camilan kampung yang mengenyangkan, kaya karbohidrat dan protein.',
            'instructions' => "1. Kupas singkong, cuci bersih dan potong-potong\n2. Rebus singkong dalam air hingga empuk (20-25 menit)\n3. Sangrai kacang tanah hingga matang dan harum\n4. Tumbuk kacang tanah kasar\n5. Parut kelapa segar, sangrai sebentar\n6. Campurkan kacang tumbuk dan kelapa sangrai\n7. Tambahkan sedikit garam\n8. Taburi singkong rebus dengan campuran kacang kelapa\n9. Sajikan hangat atau suhu ruang",
            'servings' => 4,
            'age_group' => '4-6 tahun',
            'is_published' => true,
        ]);
        $recipe26->ingredients()->attach([
            $ingredients['Singkong']->id => ['quantity_grams' => 150],
            $ingredients['Kacang Tanah']->id => ['quantity_grams' => 30],
            $ingredients['Kelapa Parut']->id => ['quantity_grams' => 20],
        ]);

        // ── Seed Resep Lokal "Isi Piringku" ──
        $this->call(IsiPiringkuSeeder::class);
    }
}
