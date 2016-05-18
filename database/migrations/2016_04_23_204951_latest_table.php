<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LatestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('row')->unsigned();
            $table->integer('col')->unsigned();
            $table->integer('size')->unsigned();
            $table->integer('offset')->unsigned();
            $table->integer('type')->unsigned();
            $table->string('name');
            $table->string('content');
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
        Schema::drop('latest');
    }
}
