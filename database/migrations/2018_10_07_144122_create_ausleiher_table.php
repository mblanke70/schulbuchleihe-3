<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAusleiherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ausleiher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schuljahr_id')->unsigned()->nullable(); 
            $table->integer('user_id')->unsigned()->nullable(); 
            $table->integer('klasse_id')->unsigned()->nullable(); 
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
        Schema::dropIfExists('ausleiher');
    }
}
