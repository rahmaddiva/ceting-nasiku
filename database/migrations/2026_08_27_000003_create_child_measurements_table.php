<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->onDelete('cascade');
            $table->date('measured_at');
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index(['child_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_measurements');
    }
};
