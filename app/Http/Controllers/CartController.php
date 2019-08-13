<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;

class CartController extends Controller
{
    // 加入购物车
    public function add(AddCartRequest $request)
    {
        $user = $request->user();
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');
        //从数据库中查询该产品是否已经在购物车了
        if ($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()) {
            //如果存在则直接叠加商品数量
            $cart->update(['amount' => $cart->amount + $amount]);
        } else {
            //否则的话创建一个新建的购物车记录
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];
    }
}