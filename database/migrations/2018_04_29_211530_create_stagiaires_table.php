<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagiairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->increments('id_stagiaire');
            $table->string('nom_stagiaire')->nullable();
            $table->string('prenom_stagiaire')->nullable();
            $table->string('photo_stagiaire')->nullable();
            $table->string('adresse_stagiaire')->nullable();
            $table->string('email_stagiaire')->nullable();
            $table->string('tel_stagiaire')->nullable();
            $table->date('dateNaissance_stagiaire')->nullable();
            $table->string('specialite_stagiaire')->nullable();
            $table->string('annee_universitaire_stagiaire')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('stagiaires');
    }
}
