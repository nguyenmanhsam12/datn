<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'code' => 'required|unique:coupons,code,' . $this->route('id') . '|max:255', // Mã giảm giá phải duy nhất trừ khi đó là mã đang sửa
            'discount_type' => 'required|in:percentage,fixed', // Loại giảm giá phải là 'percentage' hoặc 'fixed'
            'discount_value' => 'required|numeric|min:0', // Giá trị giảm giá phải là số và không nhỏ hơn 0
            'minimum_order_value' => 'required|numeric|min:0', // Giá trị tối thiểu của đơn hàng phải là số và không nhỏ hơn 0
            'maximum_discount' => 'required|numeric|min:0',
            'end_date' => 'required|date|after_or_equal:today', // Ngày hết hạn phải là ngày hợp lệ và không nhỏ hơn ngày hiện tại
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá đã tồn tại, vui lòng nhập mã khác.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.in' => 'Loại giảm giá phải là phần trăm hoặc giá trị cố định.',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'minimum_order_value.required' => 'Giá trị tối thiểu của đơn hàng là bắt buộc.',
            'minimum_order_value.numeric' => 'Giá trị tối thiểu của đơn hàng phải là số.',
            'minimum_order_value.min' => 'Giá trị tối thiểu của đơn hàng không được nhỏ hơn 0.',
            'end_date.required' => 'Ngày hết hạn là bắt buộc.',
            'end_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày hết hạn phải là ngày hôm nay hoặc sau đó.',
        ];
    }
}
