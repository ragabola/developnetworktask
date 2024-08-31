<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags'],
        ]);

        $tag = Tag::create($attributes);

        return response()->json($tag, 201);
    }

    public function update(Request $request, Tag $tag)
    {
        $attributes = $request->validate([
            'name' => ['string', 'max:255', 'unique:tags'],
        ]);

        $tag->update($attributes);

        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json(null, 204);
    }
}
