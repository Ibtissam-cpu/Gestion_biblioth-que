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
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livre_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_emprunt');
            $table->date('date_retour_prevue');
            $table->date('date_retour')->nullable();
            $table->text('commentaire')->nullable();
            $table->enum('etat_avant', ['Neuf', 'Bon', 'Moyen', 'Mauvais'])->default('Bon');
            $table->enum('etat_apres', ['Neuf', 'Bon', 'Moyen', 'Mauvais'])->nullable();
            $table->boolean('prolonge')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};