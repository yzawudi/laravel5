<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //展示界面
    public function setting()
    {
        $me = \Auth::user();
        return view('user/setting', compact('me'));
    }
    //个人操作行为
    public function settingStore()
    {
          
    }
    public function show(User $user)
    {
       // 这个人的文章
       $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
       // 这个人的关注／粉丝／文章
       $user = \App\User::withCount(['stars', 'fans', 'posts'])->find($user->id);
       $fans = $user->fans()->get();
       $stars = $user->stars()->get();

       return view("user/show", compact('user', 'posts', 'fans', 'stars'));
    }
    public function fan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::firstOrCreate(['fan_id' => $me->id, 'star_id' => $user->id]);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function unfan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::firstOrCreate(['fan_id' => $me->id, 'star_id' => $user->id]);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
