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
        Schema::table('orders', function (Blueprint $table) {
            // Modifier les valeurs possibles pour le statut
            $table->string('status')->default('en_attente')->comment('en_attente, en_traitement, validée, payée')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revenir au statut par défaut
            $table->string('status')->default('en_attente')->comment('en_attente, payée')->change();
        });
    }
};
