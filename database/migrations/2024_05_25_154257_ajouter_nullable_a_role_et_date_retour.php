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
        //
        Schema::table('emprunts', function (Blueprint $table) {
            $table->string('role')->nullable()->change();
            $table->date('date_retour')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
         
            $table->string('role')->nullable(false)->change();
            $table->date('date_retour')->nullable(false)->change();
        });
    }
};
