<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NutritionCalculatorController;
use App\Http\Controllers\PublicRecipeController;
use App\Http\Controllers\StuntingController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/resep', [PublicRecipeController::class, 'index'])->name('recipes.index');
Route::get('/resep/{slug}', [PublicRecipeController::class, 'show'])->name('recipes.show');
Route::get('/stunting', [StuntingController::class, 'index'])->name('stunting');
Route::get('/cek-risiko', [StuntingController::class, 'cekRisiko'])->name('cek-risiko');
Route::get('/edukasi', [EducationController::class, 'index'])->name('edukasi');
Route::get('/edukasi/pola-asuh', [EducationController::class, 'polaAsuh'])->name('edukasi.pola-asuh');
Route::get('/edukasi/phbs', [EducationController::class, 'phbs'])->name('edukasi.phbs');
Route::get('/edukasi/kehamilan', [EducationController::class, 'kehamilan'])->name('edukasi.kehamilan');
Route::get('/kalkulator', [NutritionCalculatorController::class, 'index'])->name('calculator');
Route::post('/kalkulator/hitung', [NutritionCalculatorController::class, 'calculate'])->name('calculator.calculate');

// Chatbot (public – no auth required)
Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');

// Sitemap XML
Route::get('/sitemap.xml', function () {
    $recipes = Recipe::where('is_published', true)->get();
    $staticPages = [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => url('/resep'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => url('/stunting'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => url('/cek-risiko'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/edukasi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => url('/edukasi/pola-asuh'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/edukasi/phbs'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/edukasi/kehamilan'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/kalkulator'), 'priority' => '0.6', 'changefreq' => 'monthly'],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

    foreach ($staticPages as $page) {
        $xml .= '  <url>'."\n";
        $xml .= '    <loc>'.$page['url'].'</loc>'."\n";
        $xml .= '    <changefreq>'.$page['changefreq'].'</changefreq>'."\n";
        $xml .= '    <priority>'.$page['priority'].'</priority>'."\n";
        $xml .= '  </url>'."\n";
    }

    foreach ($recipes as $recipe) {
        $xml .= '  <url>'."\n";
        $xml .= '    <loc>'.url('/resep/'.$recipe->slug).'</loc>'."\n";
        $xml .= '    <lastmod>'.$recipe->updated_at->toDateString().'</lastmod>'."\n";
        $xml .= '    <changefreq>weekly</changefreq>'."\n";
        $xml .= '    <priority>0.8</priority>'."\n";
        $xml .= '  </url>'."\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (public frontend login/register)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| KMS Digital — Profil Anak & Pemantauan Tumbuh Kembang (auth)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ChildGrowthController;

Route::middleware('auth')->prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [ChildGrowthController::class, 'index'])->name('index');
    Route::get('/anak/create', [ChildGrowthController::class, 'create'])->name('children.create');
    Route::post('/anak', [ChildGrowthController::class, 'store'])->name('children.store');
    Route::get('/anak/{child}', [ChildGrowthController::class, 'show'])->name('children.show');
    Route::post('/anak/{child}/pengukuran', [ChildGrowthController::class, 'storeMeasurement'])->name('children.measurements.store');
    Route::delete('/pengukuran/{measurement}', [ChildGrowthController::class, 'destroyMeasurement'])->name('measurements.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\RecipeImageController;

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::post('recipes/generate-images', [RecipeImageController::class, 'generate'])->name('recipes.generate-images');
    Route::post('recipes/generate-single-image', [RecipeImageController::class, 'generateSingle'])->name('recipes.generate-single-image');

    Route::get('recipes/data', [RecipeController::class, 'data'])->name('recipes.data');
    Route::resource('recipes', RecipeController::class);

    Route::get('ingredients/data', [IngredientController::class, 'data'])->name('ingredients.data');
    Route::resource('ingredients', IngredientController::class);

    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::resource('categories', CategoryController::class);
});
