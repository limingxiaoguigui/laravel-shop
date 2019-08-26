<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;

class CouponCodeUnavailableException extends Exception
{

    public function __construct($message, int $code = 403)
    {
        parent::__construct($message, $code);
    }
    //当这个异常被触发时 会调用render方法来输出给用户
    public function render(Request $request)
    {
        //如果用户通过API请求，则返回JSON格式的错误信息
        if ($request->expectsJson()) {
            return  response()->json(['msg' => $this->message], $this->code);
        }
        //否者返回上一页并带错误信息
        return redirect()->back()->withErrors(['coupon_code' => $this->message]);
    }
}