<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDepartmentRequest extends FormRequest
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
        $id = $this->route('department');
        return [
//            'name' => 'required',
            'name' => 'required | unique:departments,name,'.$id.',id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function messages()
    {
        return [
            'name.unique' => 'Phòng ban đã tồn tại !',
            'name.required' => 'Vui lòng nhập tên phòng ban !'
        ];
    }
}
