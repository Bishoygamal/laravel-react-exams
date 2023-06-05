<?php

namespace App\Http\Requests\Setting;
use App\Models\Setting\UserType;
use App\Models\Setting\UserType_Translate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
 use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
class UserTypeRequest extends FormRequest
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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ]));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules= [
            'items.*.locale'=>'required',
            'items.*.type_name'=>'required'
        ];
        foreach($this->items as $key => $items) {


            if ( array_key_exists('type_id', $items) && $items['type_id'] ) { // if have an id, means an update, so add the id to ignore

                $rules = array_merge($rules, ['items.*'.$key.'.locale' =>Rule::unique('user_type__translates','locale')->where('user_type_id',$items['type_id'])]);

            }
        }

        return $rules;
    }

}
