<?php

namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use App\AdminUser;
class RoleController extends Controller
{
    //角色界面首页
    public function index()
    {
        $roles = \App\AdminRole::paginate(10);//有哪些角色
        return view("/admin/role/index",compact('roles'));
    }
    //角色创建
    public function create()
    {
        return view('Admin.role.add');
    }
    //创建角色行为
    public function store()
    {
        $this->validate(request(),[
            'name' => 'required|min:3',
            'description' =>'required'
        ]);
        \App\AdminRole::create(request(['name','description']));
        return redirect('/admin/roles');
    }
    //角色权限关系界面
    public function permission(\App\AdminRole $role)
    {
        //获取全部的权限
        $permissions =\App\AdminPermission::all();
        //获取当前角色的权限
        $myPermissions = $role->permissions;
        return view('/admin/role/permission', compact('permissions', 'myPermissions', 'role'));
    }
    //存储角色的权限
    public function storePermission(\App\AdminRole $role)
    {
        $this->validate(request(),[
            'permissions' => 'required|array'
         ]);
 
         $permissions = \App\AdminPermission::find(request('permissions'));
         $myPermissions = $role->permissions;
 
         // 对已经有的权限
         $addPermissions = $permissions->diff($myPermissions);
         foreach ($addPermissions as $permission) {
             $role->grantPermission($permission);
         }
 
         $deletePermissions = $myPermissions->diff($permissions);
         foreach ($deletePermissions as $permission) {
             $role->deletePermission($permission);
         }
         return back();
    }
}