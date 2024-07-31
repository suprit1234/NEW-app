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

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['success' => 'Post deleted successfully']);
    }

}
