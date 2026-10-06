<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('growth_standards', function (Blueprint $table) {
            $table->id();
            $table->enum('sex', ['male', 'female']);
            $table->enum('indicator', ['height_for_age', 'weight_for_age']);
            $table->unsignedTinyInteger('age_months');
            $table->decimal('l', 6, 4);
            $table->decimal('m', 8, 4);
            $table->decimal('s', 7, 5);
            $table->timestamps();

            $table->unique(['sex', 'indicator', 'age_months']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('growth_standards');
    }
};
