<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
    //收货地址列表
    public function index(Request $request)
    {
        return view('user_addresses.index', ['addresses' => $request->user()->addresses]);
    }
    //后货地址的新建页面
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }
    // 新建收货地址
    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone'
        ]));

        return redirect()->route('user_addresses.index');
    }
}
