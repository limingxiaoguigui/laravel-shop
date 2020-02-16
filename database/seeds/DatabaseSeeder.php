<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 11:32:02
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-16 16:08:50
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(UserAddressesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(CouponCodesSeeder::class);
        $this->call(OrdersSeeder::class);
    }
}