<?php

namespace App;

use App\Fan;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['name','email','password'];

    //用户的文章列表,有哪些文章
        public function posts()
    {
        return $this->hasMany(\App\Post::class, 'user_id', 'id');
    }
    //关注我的人,star_id表示我作为明星，有谁有star_id，谁是我的粉丝
    public function fans()
    {
        return $this->hasMany(\App\Fan::class,'star_id','id');
    }
    //我关注的人,我的id在哪些fan表中出现,获取我关注的用户列表
    public function stars()
    {
        return $this->hasMany(\App\Fan::class,'fan_id','id');
    }
    //我想要关注某人的行为
    public function doFan($uid)
    {
        //uid就是我的id
        $fan = new Fan();
        $fan->star_id=$uid;
        return $this->stars()->save($fan);
    }
    //我要取消对某人的关注
    public function doUnfan($uid)
    {
        $fan = new Fan();
        $fan->star_id=$uid;
        return $this->stars()->delete($fan);
    }
    //我是否已经被某个用户关注了
    public function hasFan($uid)
    {
        //$this->fans()->where('fan_id',$uid)->count();记住要返回值的。下次别犯了
        return $this->fans()->where('fan_id', $uid)->count();

    }
    //我是否关注了这个用户
    public function hasStar($uid)
    {
        $this->stars()->where('star_id',$uid)->count();
    }
    //用户收到的通知
    public function notices()
    {
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }
    //给用户增加通知
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }
}
