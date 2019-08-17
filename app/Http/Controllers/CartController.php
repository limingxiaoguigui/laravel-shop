<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Services\CartService;
use App\Models\ProductSku;

class CartController extends Controller
{

    protected $cartService;

    //利用Laravel的自动解析功能注入CartService类
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    //购物车内的商品列表
    public function index(Request $request)
    {
        $cartItems = $this->cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        return view('cart.index', ['cartItems' => $cartItems, 'addresses' => $addresses]);
    }

    // 加入购物车
    public function add(AddCartRequest $request)
    {

        $this->cartService->add($request->input('sku_id'), $request->input('amount'));
        return [];
    }
    //移除购物车内的商品
    public function remove(ProductSku $sku, Request $request)
    {

        $this->cartService->remove($sku->id);
        return [];
    }
}