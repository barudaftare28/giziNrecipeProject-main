<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nutritions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->string('name'); // nama gizi, misal Protein
            $table->string('value'); // nilai gizi, misal 10g
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('nutritions');
    }
};
