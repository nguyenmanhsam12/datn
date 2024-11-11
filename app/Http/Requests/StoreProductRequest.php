<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_text' => 'nullable|string',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallary.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.size_id' => 'required|integer',
            'variants.*.stock' => 'required|integer',
            'variants.*.price' => 'required|numeric',
            'variants.*.weight' => 'required|numeric',

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
            'gallary.*.image' => 'Từng ảnh trong bộ sưu tập phải là file ảnh hợp lệ.',
            'variants.*.size_id.required' => 'Kích cỡ cho biến thể là bắt buộc.',
            'variants.*.stock.required' => 'Số lượng cho biến thể là bắt buộc.',
            'variants.*.price.required' => 'Giá cho biến thể là bắt buộc.',
            'variants.*.weight.required' => 'Trọng lượng cho biến thể là bắt buộc.',
        ];
    }
}
