<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Post/Index', [
            'posts' => Post::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->input('search');

                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                        ->orWhereDate('created_at', $search);
                    });
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $status = $request->input('status');

                    if ($status === '1') {
                        $query->where('active', 1);
                    }

                    if ($status === '0') {
                        $query->where('active', 0);
                    }
                })
                ->latest()
                ->paginate($request->integer('per_page', 10))
                ->withQueryString(),
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status', 'all'),
            ],
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