<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Http\Requests\PostRequest;
use Inertia\Inertia;


class PostController extends Controller
{

    public function index()
    {

        return Inertia::render('Post/Index', [

            'posts' => Post::latest()->paginate(10)

        ]);
    }

    public function create()
    {

        return Inertia::render('Post/Create');
    }

    public function store(PostRequest $request)
    {

        Post::create(
            $request->validated()
        );

        return redirect()
            ->route('posts.index');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Post/Update', [
            'post' => $post
        ]);
    }

    public function update( PostRequest $request, Post $post) 
    {

        $post->update(
            $request->validated()
        );

        return redirect()
            ->route('posts.index');
    }

    public function destroy(Post $post)
    {

        $post->delete();
        return redirect()
            ->route('posts.index');
    }
}
