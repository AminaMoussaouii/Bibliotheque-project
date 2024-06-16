<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToEmpruntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');

            // Si vous voulez ajouter une contrainte de clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Supprimez la clé étrangère d'abord
            $table->dropColumn('user_id');    // Ensuite, supprimez la colonne
        });
    }
}

