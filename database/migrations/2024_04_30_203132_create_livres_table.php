<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('titre');
            $table->string('auteur');
            $table->string('isbn');
            $table->string('langue')->nullable();
            $table->string('editeur')->nullable();
            $table->date('date_edition')->nullable();
            $table->integer('nombre_pages');
            $table->integer('exp_disp');
            $table->string('discipline');
            $table->string('type_ouvrage');
            $table->string('statut');
            $table->string('rayon');
            $table->string('etage');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('livres');
    }
};