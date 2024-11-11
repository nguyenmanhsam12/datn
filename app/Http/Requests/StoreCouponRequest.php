<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => 'required|unique:coupons,code|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_value' => 'required|numeric|min:0',
            'end_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:active,expired',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'code.max' => 'Mã giảm giá không được dài quá 255 ký tự.',
            
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.in' => 'Loại giảm giá phải là "percentage" hoặc "fixed".',
            
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            
            'minimum_order_value.required' => 'Giá trị tối thiểu của đơn hàng là bắt buộc.',
            'minimum_order_value.numeric' => 'Giá trị tối thiểu của đơn hàng phải là một số.',
            'minimum_order_value.min' => 'Giá trị tối thiểu của đơn hàng không được nhỏ hơn 0.',
            
            'end_date.required' => 'Ngày hết hạn là bắt buộc.',
            'end_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hôm nay.',
            
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "expired".',
        ];
    }
}
