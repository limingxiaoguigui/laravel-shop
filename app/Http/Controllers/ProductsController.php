<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 11:32:02
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 09:16:24
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exceptions\InvalidRequestException;
use App\Models\OrderItem;
use App\Models\Category;

class ProductsController extends Controller
{
    //商品列表
    public function index(Request $request)
    {
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);
        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }
        //如果传入category_id字段，并且在数据库中有对应的类目
        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))) {
            //如果是一个父类目
            if ($category->is_directory) {
                //则筛选出该父类目所有子类目的商品
                $builder->whereHas('category', function ($query) use ($category) {
                    $query->where('path', 'like', $category->path . $category->id . '-%');
                });
            } else {
                $builder->where('category_id', $category->id);
            }
        }
        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
        if ($order = $request->input('order', '')) {
            // 是否是以 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }


        $products = $builder->paginate(16);

        return view('products.index', ['products' => $products, 'filters' => ['search' => $search, 'order' => $order], 'category' => $category ?? null]);
    }
    //商品详情页
    public function show(Product $product, Request $request)
    {
        //判断商品是否已经上架，如果没有则抛出异常
        if (!$product->on_sale) {
            throw new InvalidRequestException('商品未上架');
        }
        $favored = false;
        //用户未登陆时返回的是null已登录是返回是对象
        if ($user = $request->user()) {
            // 从当前用户已收藏的商品中索索id为当前的商品id
            // boolval()函数用户把值转为布尔值
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }
        $reviews = OrderItem::query()
            ->with(['order.user', 'productSku']) //预先加载关联关系
            ->where('product_id', $product->id)
            ->whereNotNull('reviewed_at') //筛选出已评价
            ->orderBy('reviewed_at', 'desc') //按评价时间倒序
            ->limit(10) //取出10条
            ->get();
        return view('products.show', ['product' => $product, 'favored' => $favored, 'reviews' => $reviews]);
    }
    //商品收藏
    public function favor(Product $product, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)) {
            return [];
        } else {
            $user->favoriteProducts()->attach($product);
        }
        return [];
    }
    //取消商品收藏
    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);
        return [];
    }
    //收藏列表
    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);
        return view('products.favorites', ['products' => $products]);
    }
}