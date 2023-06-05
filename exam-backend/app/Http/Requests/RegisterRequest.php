<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class RegisterRequest extends FormRequest
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
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ]));

    }

    public function messages()
    {
        return [

           'name.required' => 'Title is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is required mn hna'

        ];
    }
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
             'password_confirmation'=>'required',
            'role'=>'required',
            'subscription_id'=>'required',
            'user_type_id'=>'required'
        ];
    }
}
