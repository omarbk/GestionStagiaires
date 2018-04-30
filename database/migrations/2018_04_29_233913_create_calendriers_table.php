<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendriers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mois_stage_cal')->nullable();
            $table->string('debut_semaine_cal')->nullable();
            $table->string('fin_semaine_cal')->nullable();
            $table->string('lundi_cal')->nullable();
            $table->string('mardi_cal')->nullable();
            $table->string('mercredi_cal')->nullable();
            $table->string('jeudi_cal')->nullable();
            $table->string('vendredi_cal')->nullable();
            $table->string('fk_groupe')->nullable();
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
        Schema::dropIfExists('calendriers');
    }
}
