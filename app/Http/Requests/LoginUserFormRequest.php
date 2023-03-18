<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserFormRequest extends FormRequest
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
            'email' => 'required|email',
            "password" => "required|min:6"
        ];
    }
}
