<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbfragen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('abfragen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('child_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('jahrgang');
            $table->string('titel');
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
        //
    }
}
