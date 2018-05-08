<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationOjbectifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_objectifs', function (Blueprint $table) {
            $table->increments('id_evaluation_objectif');
            $table->integer('fk_type_objectif')->nullable();
            $table->string('objectif')->nullable();
            $table->string('annee_objectif')->nullable();
            $table->integer('coefficient')->nullable();
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
        Schema::dropIfExists('evaluation_objectifs');
    }
}
