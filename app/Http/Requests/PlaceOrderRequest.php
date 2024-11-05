<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'phone_number' => 'required|regex:/^0\d{9}$/', // Đảm bảo số điện thoại đúng định dạng
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'ward' => 'required|string|max:255', // Thêm trường ward
            'address_order' => 'required|string|max:500',
            'payment_method' => 'required|string|exists:payment_methods,id', // Chọn phương thức thanh toán
        ];
    }

    public function messages()
    {
        return [
            'recipient_name.required' => 'Tên người nhận là bắt buộc.',
            'recipient_email.required' => 'Email người nhận là bắt buộc.',
            'recipient_email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại phải bắt đầu bằng 0 và có đúng 10 chữ số.',
            'province.required' => 'Tỉnh/Thành phố là bắt buộc.',
            'city.required' => 'Thành phố là bắt buộc.',
            'ward.required' => 'Phường/Xã là bắt buộc.', // Thông báo cho trường ward
            'address_order.required' => 'Địa chỉ là bắt buộc.',
            'payment_method.required' => 'Phương thức thanh toán là bắt buộc.', // Thông báo cho phương thức thanh toán
        ];
    }
}
