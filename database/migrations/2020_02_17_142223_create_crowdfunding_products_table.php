<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-17 14:22:24
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 14:23:39
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrowdfundingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfunding_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('target_amount', 10, 2);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->unsignedInteger('user_count')->default(0);
            $table->dateTime('end_at');
            $table->string('status')->default(\App\Models\CrowdfundingProduct::STATUS_FUNDING);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfunding_products');
    }
}