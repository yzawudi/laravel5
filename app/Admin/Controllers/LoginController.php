<?php

namespace App\Admin\Controllers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }
    public function login()
    {
//验证
$this->validate(request(), [
    'name' => 'required',
    'password' => 'required|min:6|max:30',
]);

//逻辑
$user = request(['name', 'password']);
if (true == \Auth::guard("admin")->attempt($user)) {
   return redirect('/admin/home');
}

return \Redirect::back()->withErrors("用户名密码错误");
    }
    public function logout()
    {
        \Auth::guard("admin")->logout();
        return redirect('/admin/login');
    }
}
