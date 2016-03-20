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
            $table->string('cover');

            //款式
            $table->bigInteger('color_id');
            $table->string('color_name', 32);

            //尺码
            $table->bigInteger('size_id');
            $table->string('size_name', 8);

            //数量
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
