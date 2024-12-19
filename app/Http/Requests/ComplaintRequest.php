<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
            'order_id' => 'required|exists:orders,id', // Mã đơn hàng phải tồn tại trong bảng orders
            'complaint_details' => 'required|string|min:2|max:500', // Chi tiết khiếu nại (10-500 ký tự)
            'complaint_type' => 'required|in:Hàng bị lỗi,Giao hàng muộn,Sản phẩm không đúng mô tả', // Lý do phải nằm trong danh sách được định nghĩa
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Tệp đính kèm (nếu có), hỗ trợ hình ảnh và PDF, mỗi tệp tối đa 2MB
        ];
        
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Mã đơn hàng là bắt buộc.',
            'order_id.exists' => 'Mã đơn hàng không tồn tại.',
            'complaint_details.required' => 'Chi tiết khiếu nại là bắt buộc.',
            'complaint_details.min' => 'Chi tiết khiếu nại phải có ít nhất 10 ký tự.',
            'complaint_details.max' => 'Chi tiết khiếu nại không được vượt quá 500 ký tự.',
            'complaint_type.required' => 'Bạn phải chọn loại khiếu nại.',
            'complaint_type.in' => 'Loại khiếu nại không hợp lệ.',
            'attachments.*.file' => 'Tệp tải lên phải là một tệp hợp lệ.',
            'attachments.*.mimes' => 'Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, pdf.',
            'attachments.*.max' => 'Mỗi tệp không được vượt quá 2MB.',
        ];
    }
}
