<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,' . $this->id,
            'email' => 'required|email|unique:users,email,'. $this->id,
            'active' => 'required',
            'password' => 'sometimes|required',
            'retype_password' => 'required_with:password|same:password',
            'role' => 'required',
            'client_id' => 'exists:clients,id',
        ];
    }
}
