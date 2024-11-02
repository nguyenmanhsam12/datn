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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|digits_between:10,15',
            'role_id' => 'required|array',
            'role_id.*' => 'exists:roles,id', // Kiểm tra từng phần tử trong mảng role_id
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên người dùng là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số.',
            'role_id.required' => 'Bạn phải chọn ít nhất một vai trò.',
            'role_id.*.exists' => 'Vai trò đã chọn không hợp lệ.',
        ];
    }
}
