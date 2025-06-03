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
        Schema::create('recommandations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livre_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('commentaire');
            $table->enum('type', ['general', 'categorie', 'age'])->default('general');
            $table->foreignId('categorie_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->integer('priorite')->default(2); // 1=basse, 2=normale, 3=haute
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommandations');
    }
};