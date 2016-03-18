<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductionImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('production_color_id')->unsigned();
            $table->bigInteger('image_id')->unsigned();

            $table->tinyInteger('primary', false, true);
            $table->timestamps();

            //foreign key
            $table->foreign('production_color_id')
                ->references('id')
                ->on('production_color')
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
        Schema::drop('production_image');
    }
}
