<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeTeam extends FormRequest
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
            'id' => 'required|exists:members',
            'team_id' => 'required|exists:teams,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The ID of the member is required to update.',
            'id.exists' => 'The specified member doesn\'t exist.',
            'team_id.required' => 'The ID of the team is required to update.',
            'team_id.exists' => 'The specified team doesn\'t exist.',
        ];
    }
}
