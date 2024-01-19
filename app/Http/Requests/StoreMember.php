<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMember extends FormRequest
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
            'first_name' => 'required|regex:/^[^\d]+$/',
            'last_name' => [
                'required',
                'regex:/^[^\d]+$/',
                Rule::unique('members', 'last_name')->where(function ($query) {
                    return $query->where('first_name', $this->first_name);
                }),

            ],
            'team_id' => 'required|exists:teams,id',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'A first name is required.',
            'first_name.regex' => 'A first name can\'t contain numbers.',
            'last_name.required' => 'A last name is required.',
            'last_name.regex' => 'A last name can\'t contain numbers.',
            'last_name.unique' => 'A member with that first name and last name combination already exist.',
            'team_id.required' => 'A team ID required.',
            'team_id.exists' => 'The team ID provided is invalid.',
        ];
    }
}
