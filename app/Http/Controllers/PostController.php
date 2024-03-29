<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = auth()->user();

        return view('post.index', compact('posts', 'user'));
    }

    public function mypost() {
        $userId = auth()->user()->id;
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('post.mypost', compact('posts'));
    }

    public function mycomment() {
        $user_id = auth()->user()->id;
        $comments = Comment::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('post.mycomment', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $inputs = $request->validate([
            'title' => 'required|max:30',
            'body' => 'required|max: 100',
            'image' => 'image|max:1024'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;

        if (request('image')) {
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His').'_' . $original; // 日時追加
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();
        return redirect()->route('post.index')->with('message', '投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:1000',
            'image'=> 'image|max:1024'
        ]);

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

        if (request('image')) {
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->comments()->delete();
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました。');
    }
}
