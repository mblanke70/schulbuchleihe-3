<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeihverfahrenUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leihverfahren_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leihverfahren_id')->unsigned()->nullable(); 
            $table->integer('user_id')->unsigned()->nullable(); 
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
        Schema::dropIfExists('leihverfahren_user');
    }
}
