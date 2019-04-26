<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class PostTopicController extends Controller
{
    //
    public function show(Topic $topic)
    {
       return view(); 
    }
    public function submit(Topic $topic)
    {
        
    }
}
