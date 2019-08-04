<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    // 写入数据库的字段
    protected  $fillable = [
        'province', 'city', 'district', 'address', 'zip', 'contact_name', 'contact_phone', 'last_used_at'
    ];
    // 日期格式的字段
    protected $dates = ['last_used_at'];
    // 与用户的关联关系
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 返回完整的地址
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}