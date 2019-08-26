<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    //从数据库中随即取出一个商品
    $product = Product::query()->where('on_sale', true)->inRandomOrder()->first();
    //该商品的sku中随机去一条
    $sku = $product->skus()->inRandomOrder()->first();
    return [
        'amount' => random_int(1, 5),
        'price' => $sku->price,
        'rating' => null,
        'reviewed_at' => null,
        'product_id' => $product->id,
        'product_sku_id' => $sku->id,
    ];
});