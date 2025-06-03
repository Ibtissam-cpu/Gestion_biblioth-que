<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('telephone')->nullable();
        $table->string('adresse')->nullable();
        $table->date('date_inscription')->default(now());
        $table->enum('role', ['admin', 'bibliothecaire', 'membre'])->default('membre');
        $table->boolean('actif')->default(true);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
