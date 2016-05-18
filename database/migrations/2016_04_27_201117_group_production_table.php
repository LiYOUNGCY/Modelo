<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupProductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_production', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('series_group_id')->unsigned();
            $table->bigInteger('production_id')->unsigned();
            $table->timestamps();

            $table->foreign('series_group_id')
                ->references('id')
                ->on('series_group')
                ->onDelete('cascade');

            $table->foreign('production_id')
                ->references('id')
                ->on('production')
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
        Schema::drop('group_production');
    }
}
