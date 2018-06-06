<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuecherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buecher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kennung');
            $table->boolean('ausgeliehen')->nullable();
            $table->integer('anschaffungsjahr');
            $table->decimal('neupreis', 4, 2);
            $table->decimal('leihgebuehr', 4, 2);
            $table->date('ausgabedatum')->nullable();
            $table->date('rueckgabedatum')->nullable();
            $table->date('aufnahmedatum')->nullable();
            $table->integer('vorbesitzerzahl')->nullable();
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
        Schema::dropIfExists('buecher');
    }
}
