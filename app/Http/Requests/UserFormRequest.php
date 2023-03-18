<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
     * @param int $id
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "last_name" => "required",
            'email' => 'required|email:rfc,dns|unique:users,email,'.$this->route('user'),
            "password" => "required|min:6",
            "phone" => "required",
            "net_income" => "required|integer"
        ];
    }
}
