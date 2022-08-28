<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserProfileRequest extends FormRequest
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
        $id = $this->route('user');
        return [
            'firstName'=>'required',
            'lastName'=>'required',
            'date_of_birth' => 'required',
            'address' => 'required',
//            'phone' => 'required | max:10'
            'phone' => 'required | unique:profiles,phone,'.$id.',user_id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function messages()
    {
        return [
            'firstName.required'=>'Tên người dùng chưa được nhập',
            'lastName.required'=>'Tên người dùng chưa được nhập',
            'address.required' => 'Cần nhập địa chỉ',
            'phone.unique' => 'Số điện thoại đã tồn tại !!!'
        ];
    }


}
