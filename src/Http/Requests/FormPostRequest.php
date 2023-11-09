<?php

namespace IBoot\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormPostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'max:255',
                Rule::unique('posts')->ignore(request('id')),
            ],
            'slug' => [
                'required',
                'max:255',
                Rule::unique('posts')->ignore(request('id')),
            ],
            'short_content' => [
                'required',
                'max:255',
            ],
            'content' => [
                'required',
            ],
        ];
    }
}
