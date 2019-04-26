<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTopic extends Model
{
    //
    protected $table = "post_topics";
    protected $fillable = ['post_id','topic_id'];
    public function scopeInTopic($query, $topic_id)
    {
        return $query->where('topic_id', $topic_id);
    }
}
