<?php

namespace App\Http\Requests\Setting;
use App\Models\Setting\Subscription;
use App\Models\Setting\Subscriptions_translate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
 use Illuminate\Contracts\Validation\Validator;
//use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
class SubscriptionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $rules= [
            'items.*.locale'=>'required',
            'items.*.sub_name'=>'required',
            'items.*.sub_type'=>'required',
            'items.*.sub_limit'=>'required',
        ];
        foreach($this->items as $key => $items) {


            if ( array_key_exists('subscription_id', $items) && $items['subscription_id'] ) { // if have an id, means an update, so add the id to ignore

                $rules = array_merge($rules, ['items.*'.$key.'.locale' =>Rule::unique('subscriptions_translates','locale')->where('subscription_id',$items['subscription_id'])]);

            }
        }

        return $rules;
    }
}
