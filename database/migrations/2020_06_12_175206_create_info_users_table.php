<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infousers', function (Blueprint $table) {
            $table->id()->autoIncrement();;
            $table->string('id_user');
            //$table->foreign('id_user')->references('id')->on('users');
            $table->string('nom_',150);
            $table->string('prenom',150);
            $table->string('tel',150)->nullable();
            $table->string('adresse',150)->nullable();
            $table->string('sexe','20')->nullable();
            $table->string('img',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infousers');
    }
}
