<?php
namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use \App\AdminUser;
class UserController extends Controller
{
    public function index()
    {
        $users =AdminUser::paginate(10);
        return view('Admin.user.index',compact('users'));
    }
    public function create()
    {
        return view('/admin/user/add');
    }
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'password' => 'required',
        ]);
        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name','password'));
        return redirect('/admin/users');
    }
    //用户角色页面
    public function role(\App\AdminUser $user)
    {
        //得到所有的角色
        $roles= \App\AdminRole::all();
        //取出属于自己的角色
        $myRoles = $user->roles;
        return view('Admin.user.role',compact('roles','myRoles','user'));

    }
 //存储用户角色
    public function storeRole(\App\AdminUser $user)
    {
        $this->validate(request(),[
            'roles' => 'required|array'
        ]);

        $roles = \App\AdminRole::find(request('roles'));
        $myRoles = $user->roles;

        // 对已经有的权限
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role) {
            $user->roles()->save($role);
        }

        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }
        return redirect('/admin/users');
    }
}