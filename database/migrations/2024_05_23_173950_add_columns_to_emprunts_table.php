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
        Schema::table('emprunts', function (Blueprint $table) {
            $table->string('nom')->nullable();
            $table->string('prénom')->nullable();
            $table->string('email')->nullable();
            $table->string('Role');
            $table->string('titre')->nullable();
            $table->string('type_ouvrage')->nullable();
            $table->string('isbn')->nullable();
            $table->date('date_limite')->nullable();
            $table->date('date_retour');
            $table->integer('nbr_jrs_retard')->nullable();
            $table->string('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('email');
            $table->dropColumn('role');
            $table->dropColumn('titre');
            $table->dropColumn('type_ouvrage');
            $table->dropColumn('isbn');
            $table->dropColumn('date_limite');
            $table->dropColumn('date_retour');
            $table->dropColumn('nbr_jrs_retard');
            $table->dropColumn('statut');
        });
    }
};
