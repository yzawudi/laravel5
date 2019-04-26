<?php
namespace App\Admin\Controllers;
use Illuminate\Http\Request;
class TopicController extends Controller
{
    public function index()
    {
        $topics = \App\Topic::all();
        return view('admin/topic/index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/topic/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required'
        ]);

        \App\Topic::create(request(['name']));
        return redirect('/admin/topics');
    }
    public function destroy(\App\Topic $topic)
    {
        $topic->delete();
        return [
            'error' => 0,
            'msg' => '',
        ];
    }
}
