<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Mettre à jour le premier utilisateur en admin
        DB::table('users')
            ->where('id', 1)
            ->update(['role' => 'admin']);
    }

    public function down()
    {
        DB::table('users')
            ->where('id', 1)
            ->update(['role' => 'membre']);
    }
}; 