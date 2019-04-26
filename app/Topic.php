<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Topic extends Model
{
    protected $table = "topics";
    protected $fillable = ['name'];
    //属于这个专题的所有文章
    public function posts()
    {
        //第一个参数是代表post和topic进行关联的表,第二个则表示的是当前外键
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
    //专题的文章数
    public function postTopics()
    {
       return $this->hasMany(\App\PostTopic::class,'topic_id'); 
    }

}
