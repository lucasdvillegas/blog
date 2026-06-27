<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{
     *   title: array<int, string>,
     *   slug: array<int, string>,
     *   description: array<int, string>,
     *   content: array<int, string>,
     *   active: array<int, string>
     * }
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
            'content' => [
                'required',
                'string',
                'min:20',
                'max:10000',
            ],
            'active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
