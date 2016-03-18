<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('production_id')->unsigned();

            $table->string('production_name');
            $table->bigInteger('cover_id');
            $table->integer('quantity')->unsigned();
            $table->float('price');//单价
            $table->float('total');//总价 total = price * quantity
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('order')
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
        Schema::drop('order_item');
    }
}
