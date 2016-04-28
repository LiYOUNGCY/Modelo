<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductionColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_color', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('production_id')->unsigned();
            $table->bigInteger('image_id')->unsigned();

            $table->string('name', 32);
            $table->string('alias', 32);
            $table->float('price')->unsigned();
            $table->timestamps();

            //foreign key
            $table->foreign('production_id')
                ->references('id')
                ->on('production')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
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
        Schema::drop('production_color');
    }
}
