<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_notes', function (Blueprint $table) {
            $table->increments('id_total_note');
            $table->integer('fk_evaluation');
            $table->double('totalNotes');
            $table->double('noteStage');
            $table->double('noteFinal');
            $table->integer('nombreAbsence');
            $table->string('etat');
            $table->string('commentaire')->nullable();

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
        Schema::dropIfExists('total_notes');
    }
}
