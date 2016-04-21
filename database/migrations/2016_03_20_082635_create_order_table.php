<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();

            $table->string('order_no', 32)->unique();
            $table->string('wechat_order_no', 32)->unique();
            $table->string('phone', 16);
            $table->string('contact', 16);
            $table->string('address', 128);
            $table->string('tracking_no');          //快递单号
            $table->string('express');              //快递公司

            $table->string('remark');               //备注

            $table->float('total');
            $table->timestamp('last_action_at');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
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
        Schema::drop('order');
    }
}
