<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeMembers extends FormRequest
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
            'id' => 'required|exists:projects',
            'members_ids' => 'sometimes|array',
            'members_ids.*' => 'sometimes|required|exists:members,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The ID of the project is required to update.',
            'id.exists' => 'The specified project doesn\'t exist.',
            'members_ids.*.exists' => 'A member ID doesn\'t exist.',
        ];
    }
}
