<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Zan;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    public function index()
    {
        $posts =Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(6);
        $posts->load('user');
        return view('Post.index',compact('posts'));
    }
    public function create()
    {
        return view("Post.create");
    } 

    public function show(Post $post)
    {
        $post->load('comments');
        return view('Post.show',compact('post'));
    }
    public function edit(Post $post)
    {
        return view('Post.edit',compact('post'));
    }
    public function update(Post $post)
    {
        //权限控制
        $this->authorize('update',$post);
        //验证
        $this->validate(request(),[
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10',
        ]);
        //逻辑
            $post->title = request('title');
            $post->content = request('content');
            $post->save();
        //渲染
        return redirect("/posts/{$post->id}");
    }
    //create 逻辑控制
    public  function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:10',
        ]);
        $params = array_merge(request(['title', 'content']), ['user_id' => \Auth::id()]);
        Post::create($params);
        return redirect('/posts');
    }
    public function imageUpload(Request $request)
    {
        $path =$request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }
    public function delete(Post $post)
    {
        //权限控制
        $this->authorize('delete',$post);
        $post->delete();

        return redirect("/posts");
    }
    public function comment(Post $post)
    {
        $this->validate(request(),[
            'post_id' => 'required|exists:posts,id',
            'content' => 'required',
        ]);
        $user_id = \Auth::id();
        $params = array_merge(
            compact('user_id'),
            request(['post_id', 'content'])
        );
        \App\Comment::create($params);
        return back();
    }
    //赞
    public function zan(Post $post)
    {
        $zan = new Zan();
        $zan->user_id = \Auth::id();
        $post->zans()->save($zan);
        return back();
    }
     public function unzan(Post $post)
     {
        $post->zan(\Auth::id())->delete();
        return back();
     }
     //搜索结果页
     public function search()
     {
        $this->validate(request(),[
            'query' => 'required'
        ]);

        $query = request('query');
        //paginate其中有total函数，可以统计数据量
        $posts = Post::search(request('query'))->paginate(10);
        return view('Post.search', compact('posts', 'query'));
     }
     //全局scope的方式
     
}
