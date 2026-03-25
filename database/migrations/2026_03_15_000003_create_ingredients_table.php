<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit')->default('gram');
            $table->decimal('calories', 8, 2)->default(0)->comment('per 100g');
            $table->decimal('protein', 8, 2)->default(0)->comment('per 100g in grams');
            $table->decimal('fat', 8, 2)->default(0)->comment('per 100g in grams');
            $table->decimal('carbohydrates', 8, 2)->default(0)->comment('per 100g in grams');
            $table->decimal('fiber', 8, 2)->default(0)->comment('per 100g in grams');
            $table->decimal('calcium', 8, 2)->default(0)->comment('per 100g in mg');
            $table->decimal('iron', 8, 2)->default(0)->comment('per 100g in mg');
            $table->decimal('vitamin_a', 8, 2)->default(0)->comment('per 100g in mcg');
            $table->decimal('vitamin_c', 8, 2)->default(0)->comment('per 100g in mg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
