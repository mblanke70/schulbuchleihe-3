<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuchtitelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buchtitel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titel');
            $table->string('verlag')->nullable();
            $table->decimal('preis', 4, 2)->nullable();
            $table->string('kennung');
            $table->integer('bestand')->nullable();
            $table->integer('ausgeliehen')->nullable();
            $table->decimal('leihgebuehr', 4, 2)->nullable();
            $table->string('isbn');
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
        Schema::dropIfExists('buchtitel');
    }
}
