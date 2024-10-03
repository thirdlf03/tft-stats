<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {

    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $post->comments()->create([
        'comment' => $request->comment,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment)
    {
        return view('posts.comments.show', compact('post', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Comment $comment)
    {
        return view('posts.comments.edit', compact('post', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment->update($request->only('comment'));

        return redirect()->route('posts.comments.show', [$tweet, $comment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('posts.show', $post);
    }
}
