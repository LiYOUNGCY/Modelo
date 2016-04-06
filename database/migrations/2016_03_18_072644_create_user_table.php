<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname', 32);
            $table->string('password');

            $table->tinyInteger('can_buy')->default(0);      //购买标识
            $table->tinyInteger('can_qrcode')->default(0);   //查看二维码的标识
            $table->tinyInteger('get_qrcode')->default(1);    //是否能扫二维码
            $table->string('referee');                      //推荐人

            $table->float('freeze_total');      // 1 + 2 级的冻结
            $table->float('freeze_three');      // 3 级冻结
            $table->float('available_total');   // 1 + 2 + 3 级的可用

            $table->float('total');
            $table->float('used_total');        //已提现

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
        Schema::drop('user');
    }
}
