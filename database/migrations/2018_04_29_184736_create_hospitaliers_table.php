<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitaliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitaliers', function (Blueprint $table) {
            $table->increments('id_hospitalier');
            $table->string('nom_hospitalier')->nullable();
            $table->string('adresse_hospitalier')->nullable();
            $table->string('tel_hospitalier')->nullable();
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
        Schema::dropIfExists('hospitaliers');
    }
}
