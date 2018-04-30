<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->increments('id_responsable');
            $table->string('nom_responsable')->nullable();
            $table->string('prenom_responsable')->nullable();
            $table->string('photo_responsable')->nullable();
            $table->string('adresse_responsable')->nullable();
            $table->string('email_responsable')->nullable();
            $table->string('tel_responsable')->nullable();
            $table->date('dateNaissance_responsable')->nullable();
            $table->string('service_responsable')->nullable();
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
        Schema::dropIfExists('responsables');
    }
}
