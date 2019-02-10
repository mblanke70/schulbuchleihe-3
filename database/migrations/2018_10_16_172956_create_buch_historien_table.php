<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuchHistorienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buch_historien', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buch_id');
            $table->string('name');
            $table->string('vorname');
            $table->string('klasse');
            $table->dateTime('ausgabe');
            $table->dateTime('rueckgabe');            
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
        Schema::dropIfExists('buch_histories');
    }
}
