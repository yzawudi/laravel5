<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Post;

class PostPolicy
{
    use HandlesAuthorization;
    //权限抽象出一个类，可以自由的定义权限的使用
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $user,Post $post)
    {
        return $user->id == $post->user_id;
    }
    public function delete(User $user,Post $post)
    {
        return $user->id == $post->user_id;
    }
}
