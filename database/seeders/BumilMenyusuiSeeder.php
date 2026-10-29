<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class BumilMenyusuiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            return;
        }

        $category = Category::firstOrCreate(
            ['slug' => 'ibu-hamil-menyusui'],
            [
                'name' => 'Ibu Hamil & Menyusui',
                'description' => 'Menu tinggi protein, zat besi, kalsium, dan asam folat untuk ibu hamil dan menyusui.',
            ]
        );

        $ing = Ingredient::all()->keyBy('name');

        // [title, slug, description, age_group, ingredients[name => gram], instructions]
        $recipes = [
            [
                'Sup Ayam Kampung Daun Kelor',
                'sup-ayam-kampung-daun-kelor',
                'Sup bening ayam dengan daun kelor dan wortel — sumber protein hewani, zat besi, dan vitamin A untuk ibu hamil.',
                'Ibu Hamil',
                ['Daging Ayam' => 80, 'Daun Kelor' => 30, 'Wortel' => 40, 'Kentang' => 50, 'Tomat' => 20],
                "1. Rebus ayam dalam air hingga mendidih, buang air rebusan pertama\n2. Masukkan wortel dan kentang, masak hingga setengah lunak\n3. Tambahkan daun kelor dan tomat, masak 3 menit\n4. Bumbui dengan garam secukupnya, sajikan hangat",
            ],
            [
                'Tumis Tempe Kacang Panjang',
                'tumis-tempe-kacang-panjang',
                'Tumis sederhana kaya protein nabati dan serat, cocok untuk menu harian ibu hamil.',
                'Ibu Hamil',
                ['Tempe' => 80, 'Kacang Panjang' => 60, 'Tomat' => 20, 'Minyak Zaitun' => 5],
                "1. Potong tempe dan kacang panjang\n2. Tumis tempe dengan minyak zaitun hingga kuning keemasan\n3. Masukkan kacang panjang dan tomat, aduk rata\n4. Tambahkan sedikit air, masak hingga matang",
            ],
            [
                'Ikan Kembung Panggang Tomat',
                'ikan-kembung-panggang-tomat',
                'Ikan kembung kaya omega-3 dan protein untuk mendukung pertumbuhan janin.',
                'Ibu Hamil',
                ['Ikan Kembung' => 100, 'Tomat' => 30, 'Minyak Zaitun' => 5],
                "1. Bersihkan ikan kembung, lumuri garam dan perasan jeruk\n2. Letakkan irisan tomat di atas ikan\n3. Olesi minyak zaitun, panggang 15-20 menit\n4. Sajikan dengan nasi hangat dan sayur",
            ],
            [
                'Sayur Bening Daun Katuk Jagung',
                'sayur-bening-daun-katuk-jagung',
                'Sayur bening daun katuk yang dipercaya membantu kelancaran ASI, dipadukan jagung manis.',
                'Ibu Menyusui',
                ['Daun Katuk' => 50, 'Jagung Manis' => 60, 'Tomat' => 20],
                "1. Didihkan air, masukkan jagung manis yang sudah dipotong\n2. Masak hingga jagung lunak\n3. Masukkan daun katuk dan tomat, masak 2 menit\n4. Tambahkan sedikit garam, sajikan",
            ],
            [
                'Nasi Tim Hati Ayam Bayam',
                'nasi-tim-hati-ayam-bayam',
                'Nasi tim lembut dengan hati ayam dan bayam — tinggi zat besi untuk mencegah anemia pada ibu menyusui.',
                'Ibu Menyusui',
                ['Beras Putih' => 60, 'Hati Ayam' => 50, 'Bayam' => 40, 'Wortel' => 30],
                "1. Masak beras dengan air lebih banyak hingga menjadi bubur kasar\n2. Rebus hati ayam, cincang halus\n3. Masukkan hati ayam, bayam, dan wortel ke dalam nasi\n4. Masak hingga semua bahan lunak, sajikan hangat",
            ],
            [
                'Bubur Kacang Hijau Santan',
                'bubur-kacang-hijau-santan',
                'Kudapan manis kacang hijau dengan santan, sumber energi dan kalsium untuk ibu menyusui.',
                'Ibu Menyusui',
                ['Kacang Hijau' => 50, 'Santan' => 40],
                "1. Rendam kacang hijau 2 jam, lalu rebus hingga lunak\n2. Tambahkan santan, masak dengan api kecil sambil diaduk\n3. Tambahkan sedikit gula dan garam\n4. Sajikan hangat atau dingin",
            ],
        ];

        foreach ($recipes as [$title, $slug, $description, $ageGroup, $items, $instructions]) {
            if (Recipe::where('slug', $slug)->exists()) {
                continue;
            }

            $recipe = Recipe::create([
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'age_group' => $ageGroup,
                'servings' => 2,
                'instructions' => $instructions,
                'is_published' => true,
            ]);

            $attach = [];
            foreach ($items as $name => $grams) {
                if (isset($ing[$name])) {
                    $attach[$ing[$name]->id] = ['quantity_grams' => $grams];
                }
            }
            $recipe->ingredients()->attach($attach);
        }
    }
}
