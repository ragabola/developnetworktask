<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->posts()
            ->filter(request(['deleted']))
            ->orderBy('pinned', 'desc')
            ->with('tags:id,name')->paginate(10);

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function store(PostRequest $request)
    {
        $attributes = $request->validated();
        $attributes['cover_image'] = $request->file('cover_image')->store('posts');

        $post = $request->user()->posts()->create($attributes);
        if ($request->tags) $post->tags()->attach($request->tags);

        return response()->json($post, 201);
    }

    public function update(PostRequest $request, Post $post)
    {
        $attributes = $request->validated();

        if ($request->hasFile('cover_image')) {
            Storage::delete($post->cover_image);
            $attributes['cover_image'] = $request->file('cover_image')->store('posts');
        }

        $post->update($attributes);
        if ($request->tags) $post->tags()->sync($request->tags);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }

    public function restore(Post $post)
    {
        if ($post->trashed()) $post->restore();

        return response()->json($post);
    }
}
