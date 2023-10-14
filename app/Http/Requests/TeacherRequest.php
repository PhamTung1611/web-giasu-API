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
        return [
            'school_id' => 'required|integer',
            'Citizen_card' => 'required|numeric|digits:12',
            'education_level' => 'required',
            'description' => 'required|string',
            'time_tutor' => 'required',
            'status' => 'required|integer',
            'DistrictID' => 'required|integer',
            'Certificate' => 'required|string',
            // Thêm các rules khác nếu cần
        ];
    }
    public function messages()
    {
        return [
            'school_id.required' => 'Vui lòng nhập school_id.',
            'school_id.integer' => 'School_id phải là một số nguyên.',
            'Citizen_card.required' => 'Vui lòng nhập số CMND.',
            'Citizen_card.numeric' => 'Số CMND phải là số.',
            'Citizen_card.digits' => 'Số CMND phải chứa đúng 9 chữ số.',
            'education_level.required' => 'Vui lòng nhập education_level.',
            'description.required' => 'Vui lòng nhập description.',
            'description.string' => 'Description phải là một chuỗi.',
            'time_tutor.required' => 'Vui lòng nhập time_tutor.',
            'status.required' => 'Vui lòng nhập status.',
            'status.integer' => 'Status phải là một số nguyên.',
            'DistrictID.required' => 'Vui lòng nhập DistrictID.',
            'DistrictID.integer' => 'DistrictID phải là một số nguyên.',
            'Certificate.required' => 'Vui lòng nhập Certificate.',
            'Certificate.string' => 'Certificate phải là một chuỗi.',
            // Thêm các messages khác nếu cần
        ];
    }

}
