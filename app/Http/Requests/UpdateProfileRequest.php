<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'province_id' => 'required|exists:province,matinh',
            'city_id' => 'required|exists:city,macity',
            'ward_id' => 'required|exists:ward,phuongid',
            'address' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ và tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email phải đúng định dạng',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'province_id.required' => 'Tỉnh/Thành phố là bắt buộc.',
            'city_id.required' => 'Quận/Huyện là bắt buộc.',
            'ward_id.required' => 'Xã/Phường là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
        ];
    }
}
