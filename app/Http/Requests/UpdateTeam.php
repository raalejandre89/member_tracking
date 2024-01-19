<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeam extends FormRequest
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
                Rule::unique('teams')->ignore($this->id),
            ],
            'id' => 'required|exists:teams',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required.',
            'name.unique' => 'A team with that name already exist.',
            'id.required' => 'The ID of the team is required to update.',
            'id.exists' => 'The specified team doesn\'t exist.',
        ];
    }
}
