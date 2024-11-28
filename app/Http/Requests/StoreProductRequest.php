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
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'required|string',
            'description_text' => 'required|string',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallary.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'required|array',
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
            'description.required' => 'Mô tả ngắn là bắt buộc.',
            'description_text.required' => 'Mô tả dài là bắt buộc.',
            'gallary.*.image' => 'Từng ảnh trong bộ sưu tập phải là file ảnh hợp lệ.',
            'variants.*.size_id.required' => 'Kích cỡ cho biến thể là bắt buộc.',
            'variants.*.stock.required' => 'Số lượng cho biến thể là bắt buộc.',
            'variants.*.price.required' => 'Giá cho biến thể là bắt buộc.',
            'variants.*.weight.required' => 'Trọng lượng cho biến thể là bắt buộc.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Lấy dữ liệu đã lưu từ session hoặc old()
        $existingVariants = session('product_attributes', old('variants', []));
        Log::info('Dữ liệu lần đầu', ['existingVariants' => $existingVariants]);

        $newVariants = $this->input('variants', []);
        Log::info('Dữ liệu lần hai', ['newVariants' => $newVariants]);

        // Kiểm tra dữ liệu cũ và mới trước khi gộp
        foreach ($newVariants as $key => $newVariant) {
            Log::info("Gộp newVariant cho key: $key", ['newVariant' => $newVariant]);

            // Kiểm tra xem key đã tồn tại trong existingVariants chưa
            if (isset($existingVariants[$key])) {
                Log::info("Key tồn tại, cập nhật variant cho key: $key", ['existingVariant' => $existingVariants[$key]]);
                // Nếu có rồi thì cập nhật
                $existingVariants[$key] = $newVariant;
            } else {
                Log::info("Key không tồn tại, thêm mới variant cho key: $key", ['newVariant' => $newVariant]);
                // Nếu không có thì thêm mới
                $existingVariants[$key] = $newVariant;
            }
        }

        Log::info('Dữ liệu lần cuối cùng', ['existingVariantsALL' => $existingVariants]);

        // Lưu dữ liệu hợp nhất vào session
        session()->put('product_attributes', $existingVariants);

        // Gọi parent xử lý lỗi validation
        parent::failedValidation($validator);
    }

}
