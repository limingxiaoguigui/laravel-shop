<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 11:32:01
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 22:47:34
 */

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class ProductsController extends CommonProductsController
{
    /**
     * 获取产品类型
     * @return void
     */
    public function getProductType()
    {
        return Product::TYPE_NORMAL;
    }
    /**
     * 列表
     * @param \Encore\Admin\Grid $grid
     * @return void
     */
    protected function customGrid(Grid $grid)
    {
        $grid->model()->with(['category']);
        $grid->id('ID')->sortable();
        $grid->title('商品名称');
        $grid->column('category.name', '类目');
        $grid->on_sale('已上架')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->price('价格');
        $grid->rating('评分');
        $grid->sold_count('销量');
        $grid->review_count('评论数');
    }
    /**
     * 表单
     * @param \Encore\Admin\Form $form
     * @return void
     */
    protected function customForm(Form $form)
    {
        // 普通商品没有额外的字段，因此这里不需要写任何代码
    }
}