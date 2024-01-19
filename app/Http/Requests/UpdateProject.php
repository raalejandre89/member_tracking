<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProject extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('projects')->ignore($this->id),
            ],
            'id' => 'required|exists:projects',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required.',
            'name.unique' => 'A project with that name already exist.',
            'id.required' => 'The ID of the project is required to update.',
            'id.exists' => 'The specified project doesn\'t exist.',
        ];
    }
}
