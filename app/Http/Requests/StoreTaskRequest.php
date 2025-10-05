<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //تميكن أي مستخدم من إضاقة بيانات
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //إضافة قواعد validation
        return [
            //'user_id' => ['exists:users,id', 'required'],
            'title' => 'required | string |max:40',
            'descryption' => 'nullable|string',
            'Priority' => 'required|in:high,medium,low'
        ];
    }

    public function messages(): array
    {
        return [
            'Priority.between' => '  يجب إدخال قيمة بين الرقم 1 و الرقم 5 '
        ];
    }
}
