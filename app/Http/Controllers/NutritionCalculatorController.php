<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class NutritionCalculatorController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('calculator', compact('ingredients'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.ingredient_id' => 'required|exists:ingredients,id',
            'items.*.quantity' => 'required|numeric|min:0.1',
        ]);

        $results = [];
        $totals = [
            'calories' => 0, 'protein' => 0, 'fat' => 0,
            'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 0,
            'iron' => 0, 'vitamin_a' => 0, 'vitamin_c' => 0,
        ];

        foreach ($request->items as $item) {
            $ingredient = Ingredient::find($item['ingredient_id']);
            $nutrition = $ingredient->nutritionFor($item['quantity']);

            $results[] = [
                'name' => $ingredient->name,
                'quantity' => $item['quantity'],
                'unit' => $ingredient->unit,
                'nutrition' => $nutrition,
            ];

            foreach ($totals as $key => &$value) {
                $value += $nutrition[$key];
            }
        }

        $totals = array_map(fn($v) => round($v, 2), $totals);

        return response()->json([
            'items' => $results,
            'totals' => $totals,
        ]);
    }
}
