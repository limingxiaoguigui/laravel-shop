<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 13:09:00
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-16 13:18:52
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //可填充属性
    protected $fillable = ['name', 'is_directory', 'level', 'path'];
    //转换属性
    protected $casts = [
        'is_directory' => 'boolean',
    ];
    /**
     * 初始化
     * @return void
     */
    protected static function  boot()
    {
        parent::boot();
        //监听category的创建事件，用于初始化path和level字段值
        static::creating(function (Category $category) {
            //如果创建的是一个根类目
            if (is_null($category->parent_id)) {
                //将层级设为0
                $category->level = 0;
                //将path设为 -
                $category->path = '-';
            } else {
                //将层级设为父类目的层级+1
                $category->level = $category->parent->level + 1;
                //将path值设为父类目的path追加父类目ID以及最后跟上一个-分隔符
                $category->path = $category->parent->path . $category->parent_id . '-';
            }
        });
    }
    /**
     * 父级类目
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * 子类目
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    /**
     * 商品
     * @return void
     */
    public function products()
    {

        return $this->hasMany(Product::class);
    }
    /**
     * 获取所有祖先类目的ID值数组
     * @return void
     */
    public function getPathIdsAttribute()
    {
        return  array_filter(explode('-', trim($this->path, '-')));
    }

    /**
     * 获取所有祖先类目并按层级排序
     * @return void
     */
    public function getAncestorsAttribute()
    {
        return Category::query()
            ->whereIn('id', $this->path_ids)
            ->orderBy('level')
            ->get();
    }
    /**
     *获取以 - 为分隔的所有祖先类目名称以及当前类目的名称
     * @return void
     */
    public function getFullNameAttribute()
    {
        return $this->ancestors
            ->pluck('name')
            ->push($this->name)
            ->implode('-');
    }
}