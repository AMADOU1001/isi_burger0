<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('burgers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du burger
            $table->decimal('price', 8, 2); // Prix du burger
            $table->text('description'); // Description du burger
            $table->string('image')->nullable(); // Image du burger (optionnelle)
            $table->integer('stock')->default(0); // Stock du burger
            $table->timestamps(); // Dates de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burgers');
    }
};
