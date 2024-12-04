<?php

namespace App\Components;

use App\Models\Category;

class Recursive
{

    public function getCategoryTree($parentId = 0 , $prefix = '' )
    {

        $categories = Category::where('parent_id', $parentId)->get();
        $options = [];

        foreach ($categories as $category) {
            // Thêm danh mục vào danh sách với tiền tố biểu diễn cấp bậc
            $options[] = [
                'id' => $category->id,
                'name' => $prefix . $category->name,
            ];

            // Gọi đệ quy để thêm các danh mục con
            $childOptions = $this->getCategoryTree($category->id, $prefix . '-- ');

            // hàm này dùng để merge các mảng lại thành 1
            $options = array_merge($options, $childOptions);
        }

        return $options;
    }

    

}
