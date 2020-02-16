<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 11:32:02
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-16 14:18:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'on_sale', 'rating', 'sold_count', 'review_count', 'price'
    ];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
    ];
    //与商品sku的关系
    public function skus()
    {

        return $this->hasMany(ProductSku::class);
    }
    // 获取图片的绝对地址
    public function getImageUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }
    /**
     * 和分类的关联关系
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}