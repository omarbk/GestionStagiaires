<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluateurs', function (Blueprint $table) {
            $table->increments('id_evaluateur');
            $table->string('nom_evaluateur')->nullable();
            $table->string('prenom_evaluateur')->nullable();
            $table->string('photo_evaluateur')->nullable();
            $table->string('adresse_evaluateur')->nullable();
            $table->string('email_evaluateur')->nullable();
            $table->string('tel_evaluateur')->nullable();
            $table->date('dateNaissance_evaluateur')->nullable();
            $table->string('service_evaluateur')->nullable();
            $table->string('specialite_evaluateur')->nullable();
            $table->string('type_evaluateur')->nullable();
            $table->integer('fk_hospitalier')->nullable();
            $table->integer('fk_user')->nullable();

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
        Schema::dropIfExists('evaluateurs');
    }
}
