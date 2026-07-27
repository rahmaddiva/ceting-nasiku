<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NutritionCalculatorController;
use App\Http\Controllers\PublicRecipeController;
use App\Http\Controllers\StuntingController;
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

    Route::get('recipes/data', [RecipeController::class, 'data'])->name('recipes.data');
    Route::resource('recipes', RecipeController::class);

    Route::get('ingredients/data', [IngredientController::class, 'data'])->name('ingredients.data');
    Route::resource('ingredients', IngredientController::class);

    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::resource('categories', CategoryController::class);
});
