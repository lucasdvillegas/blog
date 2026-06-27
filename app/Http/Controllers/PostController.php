<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Post/Index', [
            'posts' => Post::latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        Post::create($request->validated());

        return redirect()->route('posts.index');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Post/Update', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}