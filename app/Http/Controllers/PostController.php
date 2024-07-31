<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index(){
        return view('posts.index');
    }

    public function getPosts(){
        $post = Post::query()->get();
        $arr = [];
        foreach($post as $p){
            $data = new stdClass;
            $data->post_id=$p->id;
            $data->post_title = $p->title;
            $data->post_content = $p->content;
            $data->post_created_at = $p->created_at->toDateTimeString();
            $data->post_updated_at = $p->updated_at->toDateTimeString();
            $arr[] = $data;
        }
        return DataTables::of($arr)->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['success' => 'Post added successfully']);
    }

}
