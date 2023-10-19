<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'addNewUser':
                        $rules = [
                            'name' => 'required|string',
                            'phone' => 'required|string',
                            'password' => 'required|string',
                            'address' => 'required|string',
                            'email' => 'required|email|unique:users,email',
                        ];
                        break;
                    case 'updateUser':
                        $rules = [
                            'name' => 'required|string',
                            'phone' => 'required|string',
                            'password' => 'required|string',
                            'address' => 'required|string',
                            'email' => 'required|email|unique:users,email',
                        ];
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            
            default:
                # code...
                break;
        }
        return $rules;
        // return [
        //     // 'role_id' => 'required|integer',
        //     'name' => 'required|string',
        //     'avatar' => 'required|string',
        //     'phone' => 'required|string',
        //     'password' => 'required|string',
        //     'address' => 'required|string',
        //     'email' => 'required|email|unique:users,email', // Thêm kiểm tra duy nhất
        // ];
    }
    public function messages()
    {
        return [
            // 'role_id.required' => 'Vui lòng nhập role_id.',
            // 'role_id.integer' => 'Role_id phải là một số nguyên.',
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là một chuỗi.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là một chuỗi.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là một chuỗi.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
        ];
    }
}
