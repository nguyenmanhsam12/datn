<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class StoreProductRequest extends FormRequest
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
        Log::info('Data being sent:', $this->all()); // Log tất cả dữ liệu

        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'required|string',
            'description_text' => 'required|string',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallary.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.size_id' => 'required_with:variants|integer|exists:sizes,id',
            'variants.*.stock' => 'required_with:variants|integer',
            'variants.*.price' => 'required_with:variants|numeric',
            'variants.*.weight' => 'required_with:variants|numeric',    

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'sku.required' => 'Mã sản phẩm là bắt buộc.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'brand_id.required' => 'Thương hiệu là bắt buộc.',
            'image.required' => 'Hình ảnh chính là bắt buộc.',
            'description.required' => 'Mô tả ngắn là bắt buộc.',
            'description_text.required' => 'Mô tả dài là bắt buộc.',
            'gallary.*.image' => 'Từng ảnh trong bộ sưu tập phải là file ảnh hợp lệ.',
        
        ];
    }

    

}
