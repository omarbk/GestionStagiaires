<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->increments('id_stages');
            $table->string('intitule_stage')->nullable();
            $table->string('objectif_stage')->nullable();
            $table->string('objectif_stage')->nullable();
            $table->integer('fk_hospitalier')->nullable();
            $table->integer('fk_evaluateur')->nullable();
            $table->integer('fk_responsable')->nullable();
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
        Schema::dropIfExists('stages');
    }
}
