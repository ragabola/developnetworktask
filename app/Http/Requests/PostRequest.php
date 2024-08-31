<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        $post = $this->route('post') ?? null;

        return [
            'title' => ['required' , 'string' , 'max:255'],
            'body' => ['required' , 'string'],
            'cover_image' => [$post ? 'required' : 'nullable', 'image'],
            'pinned' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }

    public function prepareForValidation()
    {
        if($post = $this->route('post') ?? null){
            $this->mergeIfMissing([
                'title' => $post->title,
                'body' => $post->body,
                'pinned' => $post->pinned,
                'tags' => $post->tags->pluck('id')->toArray(),
            ]);
        }
    }
}
