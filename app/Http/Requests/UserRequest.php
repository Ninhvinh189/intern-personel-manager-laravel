<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'password' => 'min:6 | required',
            'email'=>'required|email|unique:users,email',
            'date_of_birth' => 'required',
            'address' => 'required',
            'phone' => 'required | max:10| unique:profiles,phone',
            'department' => 'required',
            'role' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    public function messages()
    {
        return [
            'firstName.required'=>'Tên người dùng chưa được nhập !',
            'lastName.required'=>'Tên người dùng chưa được nhập !',
            'address.required' => 'Cần nhập địa chỉ !',
            'phone.unique' => 'Số điện thoại đã tồn tại !',
            'phone.min' => 'Số điện thoại không hợp lệ !',
            'phone.max' => 'Số điện thoại không hợp lệ !'
        ];
    }

}
