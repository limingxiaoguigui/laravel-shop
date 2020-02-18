<?php
/*
 * @Description:
 * @Author: LMG
 * @Date: 2020-02-16 11:32:02
 * @LastEditors: LMG
 * @LastEditTime: 2020-02-18 17:25:12
 */
function route_class()
{

    return   str_replace('.', '-', Route::currentRouteName());
}
//获取外网地址
function ngrok_url($routeName, $parameters = [])
{
    //开发环境，并且配置了Ngrok_url
    if (app()->environment('local') && $url = config('app.ngrok_url')) {
        //route()函数第三个参数代表是否绝对路径
        return $url . route($routeName, $parameters, false);
    }
    return  route($routeName, $parameters);
}