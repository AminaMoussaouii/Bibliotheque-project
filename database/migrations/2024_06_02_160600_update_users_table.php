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
        Schema::table('users', function (Blueprint $table) {
            $table->string('Code_Apogée')->nullable(); // Pour Etudiant
            $table->string('CNE')->nullable(); // Pour Etudiant
            $table->string('Filière')->nullable(); // Pour Etudiant
            $table->string('department')->nullable(); // Pour Personnel
            $table->string('PPR')->nullable(); // Pour Personnel,responsable,bibliothecaire,admin


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['Code_Apogée', 'CNE', 'Filière', 'department', 'PPR']);
        });
    }

};
