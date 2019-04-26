<?php

namespace App\Admin\Controllers;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }
    public function login()
    {

    }
    public function logout()
    {
        
    }
}
