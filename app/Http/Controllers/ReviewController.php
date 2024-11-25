<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(115); // Lấy kèm người dùng và sản phẩm
        return view('admin.reviews.reviews', compact('reviews'));
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được xóa.');
    }
}
