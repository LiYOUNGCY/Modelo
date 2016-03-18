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

            $table->string('order_no', 64);
            $table->string('phone', 16);
            $table->string('contact', 16);
            $table->string('address', 128);

            $table->float('total');
            $table->string('status');
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
