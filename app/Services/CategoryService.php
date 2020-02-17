<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-17 10:41:32
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 10:42:04
 */

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    //这是一个递归方法
    //$parentId 参数代表要获取子目录的父目录ID
    //allCategories 参数代表数据库中的所有类目，如果是null代表需要从数据库中查询
    public function getCategoryTree($parentId = null, $allCategories = null)
    {
        if (is_null($allCategories)) {
            $allCategories = Category::all();
        }
        return $allCategories->where('parent_id', $parentId)
            ->map(function (Category $category) use ($allCategories) {
                //如果是当前类目不是父类目，则直接返回
                $data = ['id' => $category->id, 'name' => $category->name];
                //如果当前类目不是父类目，则直接返回
                if (!$category->is_directory) {
                    return $data;
                }
                //否则递归调用本方法，将返回值放入children字段中
                $data['children'] = $this->getCategoryTree($category->id, $allCategories);
                return  $data;
            });
    }
}