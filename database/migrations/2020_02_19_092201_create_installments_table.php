<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-19 09:22:01
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-19 09:50:00
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->decimal('total_amount');
            $table->unsignedInteger('count');
            $table->float('fee_rate');
            $table->float('fine_rate');
            $table->string('status')->default(\App\Models\Installment::STATUS_PENDING);
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
        Schema::dropIfExists('installments');
    }
}