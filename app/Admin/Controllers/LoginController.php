<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	//展示登录页面
	public function index()
	{
		return view('admin.login.index');
	}
	//登录逻辑
	public function login(Request $request)
	{
		 $this->validate($request, [
            'name' => 'required|min:2',
            'password' => 'required|min:5|max:10',
        ]);

        $user = request(['name', 'password']);
        if (\Auth::guard("admin")->attempt($user)) {
           return redirect('/admin/home');
        }

        return \Redirect::back()->withErrors("用户名密码错误");
	}	
	//登出
	public function logout()
	{
		\Auth::guard("admin")->logout();
        return redirect('/admin/login');
	}	
}