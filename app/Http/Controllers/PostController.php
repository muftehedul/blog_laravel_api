<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|max:255',
            'post_body' => 'required',
        ]);
        $id=auth()->user()->id;

        $post = Post::create([
            'post_title' => $request->post_title,
            'post_body' => $request->post_body,
            'created_by'=>$id,
            'updated_by'=>$id,
        ]);

        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required|max:255',
            'post_body' => 'required',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->update([
            'post_title' => $request->post_title,
            'post_body' => $request->post_body,
        ]);

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
