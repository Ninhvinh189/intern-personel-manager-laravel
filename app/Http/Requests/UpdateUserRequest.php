<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'phone' => 'required | min:10 | max:10 | unique:profiles,phone,'.$id.',user_id',
            'department' => 'required',
            'role' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'firstName.required'=>'Tên người dùng chưa được nhập',
            'lastName.required'=>'Tên người dùng chưa được nhập',
            'address.required' => 'Cần nhập địa chỉ',
            'phone.unique' => 'Số điện thoại đã tồn tại !!!',
            'phone.min' => 'Số điện thoại không hợp lệ',
            'phone.max' => 'Số điện thoại không hợp lệ'
        ];
    }


}
