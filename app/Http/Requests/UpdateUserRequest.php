<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'app_code' => 'required_if:user_type,3',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'user_type' => 'required',
            'country' => 'required'
        ];
    }
}
