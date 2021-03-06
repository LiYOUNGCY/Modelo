<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('series_id')->unsigned();

            //封面图
            $table->bigInteger('cover_id')->unsigned();

            //专题图
            $table->bigInteger('series_image')->unsigned();

            $table->bigInteger('size_info_id')->unsigned();
            $table->bigInteger('fabric_info_id')->unsigned();

            $table->bigInteger('click')->unsigned()->default(0);

            $table->string('name');
            $table->timestamps();


            //foreign key
            $table->foreign('series_id')
                ->references('id')
                ->on('series')
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
        Schema::drop('production');
    }
}
