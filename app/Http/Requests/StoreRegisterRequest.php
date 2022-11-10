<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class StoreRegisterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:customers',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => Lang::get('web.name-required'),

            'email' => Lang::get('web.email'),
            'email.required' => Lang::get('web.email-required'),

            'password.required' => Lang::get('web.password-required'),
            'password.confirmed' => Lang::get('web.confirm-password-same'),
        ];
    }
}