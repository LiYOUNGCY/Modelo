<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductionSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_size', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('production_color_id')->unsigned();

            $table->string('name', 8);
            $table->integer('quantity')->unsigned();
            $table->integer('amount')->unsigned();
            $table->timestamps();

            //foreign key
            $table->foreign('production_color_id')
                ->references('id')
                ->on('production_color')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('production_size');
    }
}
