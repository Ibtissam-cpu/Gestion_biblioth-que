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
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->foreignId('auteur_id')->constrained()->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->string('isbn')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('editeur')->nullable();
            $table->year('annee_publication')->nullable();
            $table->integer('nombre_pages')->nullable();
            $table->string('langue')->default('Français');
            $table->string('image')->nullable();
            $table->integer('quantite_totale')->default(1);
            $table->integer('quantite_disponible')->default(1);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};