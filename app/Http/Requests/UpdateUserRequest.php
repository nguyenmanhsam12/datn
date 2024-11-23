<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => 'required|string|max:255', // Tên người dùng bắt buộc và không vượt quá 255 ký tự
            'email' => ['required','email',Rule::unique('users')->ignore($userId)],
            'phone_number' => 'nullable|digits_between:10,15', // Số điện thoại có thể null và không vượt quá 15 ký tự
            'password' => 'nullable|string|min:6', // Mật khẩu có thể null, nếu có thì phải có ít nhất 6 ký tự và xác nhận
            'role_id' => 'required|array', // Vai trò bắt buộc và phải là một mảng
            'role_id.*' => 'exists:roles,id' // Mỗi vai trò trong mảng phải tồn tại trong bảng roles
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên người dùng là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role_id.required' => 'Vai trò là bắt buộc.',
            'role_id.array' => 'Vai trò phải là một mảng.',
            'role_id.*.exists' => 'Vai trò không hợp lệ.',
        ];
    }
}
