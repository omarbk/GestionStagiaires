<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->increments('id_absence');
            $table->date('dateDebut_absence')->nullable();
            $table->date('dateFin_absence')->nullable();
            $table->string('duree_absence')->nullable();
            $table->string('cause_absence')->nullable();
            $table->boolean('justificatif_absence')->nullable();
            $table->integer('fk_stagiaire')->nullable();
            $table->integer('fk_evaluateur')->nullable();
            $table->integer('fk_stage')->nullable();
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
        Schema::dropIfExists('absences');
    }
}
