<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSubstitutionGroupSeeder extends Seeder
{
    public function run(): void
    {
        // Sawi — bahan baru, data gizi per 100g mengikuti Tabel Komposisi Pangan Indonesia (TKPI).
        Ingredient::firstOrCreate(
            ['name' => 'Sawi'],
            [
                'name' => 'Sawi',
                'unit' => 'gram',
                'calories' => 28,
                'protein' => 2.3,
                'fat' => 0.3,
                'carbohydrates' => 4.0,
                'fiber' => 2.5,
                'calcium' => 220,
                'iron' => 2.9,
                'vitamin_a' => 0,
                'vitamin_c' => 102,
            ]
        );

        // Grup substitusi: bahan dalam grup sama dapat saling mengganti di halaman resep.
        $groups = [
            'sayur-hijau' => ['Bayam', 'Sawi', 'Daun Kelor', 'Kangkung', 'Daun Katuk', 'Daun Pepaya', 'Daun Singkong'],
            'protein-unggas' => ['Daging Ayam', 'Daging Bebek'],
            'protein-ikan' => ['Ikan Gabus', 'Ikan Patin', 'Ikan Bandeng', 'Ikan Kembung', 'Ikan Tongkol', 'Ikan Mas', 'Ikan Nila', 'Ikan Lele', 'Ikan Salmon', 'Ikan Teri', 'Ikan Tuna'],
            'protein-nabati' => ['Tahu', 'Tempe', 'Edamame'],
        ];

        foreach ($groups as $group => $names) {
            Ingredient::whereIn('name', $names)->update(['substitution_group' => $group]);
        }
    }
}
