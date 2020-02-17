<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-17 18:34:14
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 18:36:49
 */

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;

abstract class CommonProductsController extends Controller
{
    use HasResourceActions;
    //定义一个抽象方法，返回当前管理的商品类型
    abstract public function getProductType();
    /**
     * 列表
     * @param \Encore\Admin\Layout\Content $content
     * @return void
     */
    public function index(Content $content)
    {
        return $content->header(Product::$typeMap[$this->getProductType()] . '列表')
            ->body($this->grid());
    }
    /**
     * 编辑
     * @param [type] $id
     * @param \Encore\Admin\Layout\Content $content
     * @return void
     */
    public function edit($id, Content $content)
    {
        return $content->header('编辑' . Product::$typeMap[$this->getProductType()])->body($this->form()->edit($id));
    }
    /**
     * 创建
     * @param \Encore\Admin\Layout\Content $content
     * @return void
     */
    public function create(Content $content)
    {
        return $content->header('创建' . Product::$typeMap[$this->getProductType()])->body($this->form());
    }
    /**
     * grid方法
     * @return void
     */
    protected function grid()
    {

        $grid = new Grid(new Product());
        //筛选当前类型的商品，默认ID倒序排序
        $grid->model()->where('type', $this->getProductType())->orderBy('id', 'desc');
        //调用自定义方法
        $this->customGrid($grid);
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
    //定义一个抽象方法，各类型的控制器将实现本方法来定义列表应该展示哪些字段
    abstract protected function customGrid(Grid $grid);
    /**
     * 表单
     * @return void
     */
    protected function form()
    {
        $form = new Form(new Product());
        //在表单页面中添加一个名为type的隐藏字段，值为当前商品类型
        $form->hidden('type')->value($this->getProductType());
        $form->text('title', '商品名称')->rules('required');
        $form->select('category_id', '类目')->options(function ($id) {

            $category = Category::find($id);
            if ($category) {
                return [$category->id => $category->full_name];
            }
        })->ajax('/admin/api/categories?is_directory=0');
        $form->image('image', '封面图片')->rules('required|image');
        $form->editor('description', '商品描述')->rules('required');
        $form->radio('on_sale', '上架')->options(['1' => '是', '0' => '否'])->default('0');

        //调用自定义方法
        $this->customForm($form);

        $form->hasMany('skus', '商品 SKU', function (Form\NestedForm $form) {
            $form->text('title', 'SKU 名称')->rules('required');
            $form->text('description', 'SKU 描述')->rules('required');
            $form->text('price', '单价')->rules('required|numeric|min:0.01');
            $form->text('stock', '剩余库存')->rules('required|integer|min:0');
        });
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });
        return $form;
    }

    //定义一个抽象方法，各个类型的控制器将实现本方法来定义表单应该有哪些额外的字段
    abstract protected function customForm(Form $form);
}