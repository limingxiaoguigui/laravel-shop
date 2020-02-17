<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-17 14:02:53
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-17 14:03:41
 */

namespace App\Http\ViewComposers;

use App\Services\CategoryService;
use Illuminate\View\View;

class  CategoryTreeComposer
{

    protected $categoryService;
    //使用Laravel的依赖注入，自动注入我们所需的categoryService类

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    //当渲染指定的模板时，Laravel会调用compose方法
    public function compose(View $view)
    {
        //使用 with方法注入变量
        $view->with('categoryTree', $this->categoryService->getCategoryTree());
    }
}