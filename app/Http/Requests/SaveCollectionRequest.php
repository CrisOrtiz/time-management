<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCollectionRequest extends FormRequest
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
            'name' => 'required',
            'default_installment_number' => 'required|numeric',
            'default_interest' => 'required|numeric',
            'default_cupo' => 'required|numeric',
            'currency' => 'required|numeric',
            'company_id' => 'required',
            'worker_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'currency.required' => 'El campo moneda es obligatorio.',
            'company_id.required' => 'El campo empresa es obligatorio.',
            'worker_id.required' => 'El campo trabajador es obligatorio.'
        ];
    }
}
