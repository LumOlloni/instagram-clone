<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEdit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:255',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,jfif,gif,svg|max:2048',
            'tags' => 'sometimes'
        ];
    }
}
