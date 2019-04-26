<?php
namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use \App\Post;
class PostController extends Controller
{
    //首页
    public function index()
    {
        $posts =Post::withoutGlobalScope('avaiable')->where('status',0)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.post.index',compact('posts'));
    }
    //修改文章的状态
    public function status(Post $post)
    {
        $this->validate(request(), [
            "status" => 'required|in:-1,1',
        ]);

        $post->status = request('status');
        $post->save();
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}