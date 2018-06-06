<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuchtitelBuecherliste extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buchtitel_buecherliste', function (Blueprint $table) {
            $table->integer('buchtitel_id');
            $table->integer('buecherliste_id');
            $table->primary(['buchtitel_id', 'buecherliste_id']);
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
