<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductController extends FormRequest
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
        $productId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'sku' => ['required','string','max:50',Rule::unique('products')->ignore($productId)],
            'description' => 'nullable|string',
            'description_text' => 'nullable|string',
            'category_id' => 'required|exists:category,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallary.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'sku.required' => 'Mã sản phẩm là bắt buộc.',
            'sku.unique' => 'Mã sản phẩm đã tồn tại.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'image.image' => 'Ảnh chính phải là tệp ảnh.',
            'image.mimes' => 'Ảnh chính phải có định dạng jpg, jpeg hoặc png.',
            'image.max' => 'Kích thước ảnh chính tối đa là 2MB.',
            'gallary.*.image' => 'Hình ảnh phụ phải là tệp ảnh.',
            'gallary.*.mimes' => 'Hình ảnh phụ phải có định dạng jpg, jpeg hoặc png.',
            'gallary.*.max' => 'Kích thước hình ảnh phụ tối đa là 2MB.',
        ];
    }
}
