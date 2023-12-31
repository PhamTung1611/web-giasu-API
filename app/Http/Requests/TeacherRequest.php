<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'addNewTeacher':
                        $rules = [
                            'name' => 'required|string',
                            'phone' => 'required|string',
                            'password' => 'required|string',
                            'address' => 'required|string',
                            'email' => 'required|email|unique:users,email',
                            'school_id' => 'required|integer',
                            // 'Citizen_card' => 'required',
                            'education_level' => 'required',
                            'time_tutor' => 'required',
                            'status' => 'required|integer',
                            // 'DistrictID' => 'required|integer',

                        ];
                        break;
                    case 'updateTeacher':
                        $rules = [
                            'name' => 'required|string',
                            'phone' => 'required|string',
                            'password' => 'required|string',
                            'address' => 'required|string',
                            'email' => 'required|email',
                            'school_id' => 'required|integer',
                            // 'Citizen_card' => 'required',
                            'education_level' => 'required',
                            'time_tutor' => 'required',
                            'status' => 'required|integer',
                            // 'DistrictID' => 'required|integer',
                            'Certificate' => 'required|string',
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
        //     'school_id' => 'required|integer',
        //     'Citizen_card' => 'required|numeric|digits:12',
        //     'education_level' => 'required',
        //     'description' => 'required|string',
        //     'time_tutor' => 'required',
        //     'status' => 'required|integer',
        //     'DistrictID' => 'required|integer',
        //     'Certificate' => 'required|string',
        //     // Thêm các rules khác nếu cần
        // ];
    }
    public function messages()
    {
        return [
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
            'school_id.required' => 'Vui lòng nhập school_id.',
            'school_id.integer' => 'School_id phải là một số nguyên.',
            'education_level.required' => 'Vui lòng nhập education_level.',
            'time_tutor.required' => 'Vui lòng nhập time_tutor.',
            'status.required' => 'Vui lòng nhập status.',
            'status.integer' => 'Status phải là một số nguyên.',
            'Certificate.required' => 'Vui lòng nhập Certificate.',

            // Thêm các messages khác nếu cần
        ];
    }
}
