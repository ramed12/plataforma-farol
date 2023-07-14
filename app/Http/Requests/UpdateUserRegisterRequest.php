<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRegisterRequest extends FormRequest
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
            'password' => 'required| min:4| max:15 |confirmed',
            'password_confirmation' => 'required| min:4',
            'instituicao'   => 'required',
            'cargo'         => 'required',
            'phone'         => 'required'
        ];
    }
}
