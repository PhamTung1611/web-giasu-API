<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
                    case 'add':
                        $rules = [
                            'name' => 'required'
                        ];
                        break;
                    case 'edit':
                        $rules = [
                            'name' => 'required'
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
    }
    public function messages()
    {
       return [
            'name.required' => 'Bắt buộc phải nhập tên môn học'
       ];
    }
}
