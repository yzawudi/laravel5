<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class RegisterController extends Controller
{
    //界面展示
    public function index()
    {
        return view('Register.index');
    }
    //注册行为
    public function register()
    {
        $this->validate(request(),[
            'name' => 'required|min:3|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:5|confirmed',
        ]);

        $password = bcrypt(request('password'));
        $name = request('name');
        $email = request('email');
        $user = \App\User::create(compact('name', 'email', 'password'));
        return redirect('/login');
        
    }
}
