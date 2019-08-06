<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required'
        ];
    }
    // 指定字段名称
    public function attributes()
    {
        return [
            'province' => '省',
            'city' => '市',
            'district' => '区',
            'address' => '详细地址',
            'zip' => '邮编',
            'contact_name' => '姓名',
            'contact_phone' => '电话',
        ];
    }
}