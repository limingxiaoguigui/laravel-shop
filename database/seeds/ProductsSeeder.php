<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建30个产品
        $products = factory(\App\Models\Product::class, 30)->create();
        foreach ($products as $product) {
            // 创建3个SKU并且每个sku的product_id字段都应该设为当前循环的商品Id
            $skus = factory(\App\Models\ProductSku::class, 3)->create(['product_id' => $product->id]);
            //找出最低价格把商品价格设置为改价格
            $product->update(['price' => $skus->min('price')]);
        }
    }
}