<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => [
            'required',
            'string',
            'min:6', // ít nhất 8 ký tự
            'confirmed', // xác nhận mật khẩu
            'regex:/[0-9]/', // ít nhất một số
            'regex:/[!@#$%^&*(),.?":{}|<>]/', // ít nhất một ký tự đặc biệt
        ],
        'password_confirmation' => 'required|string|min:6',
    ];
}


public function messages()
{
    return [
        'name.required' => 'Tên đầy đủ là bắt buộc.',
        'name.string' => 'Tên đầy đủ phải là một chuỗi.',
        'name.max' => 'Tên đầy đủ không được vượt quá :max ký tự.',

        'email.required' => 'Email là bắt buộc.',
        'email.email' => 'Email không hợp lệ.',
        'email.unique' => 'Email đã tồn tại trong hệ thống.',
        'email.max' => 'Email không được vượt quá :max ký tự.',

        'password.required' => 'Mật khẩu là bắt buộc.',
        'password.string' => 'Mật khẩu phải là một chuỗi.',
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        'password.regex' => 'Mật khẩu phải chứa ít nhất một số và một ký tự đặc biệt.',

        'password_confirmation.required' => 'Xác nhận mật khẩu là bắt buộc.', // Thay đổi thành password_confirmation
        'password_confirmation.string' => 'Xác nhận mật khẩu phải là một chuỗi.',
        'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất :min ký tự.',
    ];
}
}
