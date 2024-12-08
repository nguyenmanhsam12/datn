<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment_Methods;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

$totalReviewsCount = Review::count();
        // Đếm số lượng tổng quanssldh
        $sldh = Order::count();
        $totalProducts = Product::count();
        $totalAdmins = User::count();
        $doanhThu = Order::whereHas('orderStatus', function ($query) {
            $query->where('name', 'Hoàn tất');
        })->get()->reduce(function ($carry, $order) {
            return $carry + ($order->total_amount - $order->discount_amount + $order->shipping_fee);
        }, 0);

        // Số lượng mã giảm giá còn hạn và đã hết hạn
        $activeCouponsCount = Coupon::where('end_date', '>', now())->count();
        $expiredCouponsCount = Coupon::where('end_date', '<', now())->count();

        // Tổng số danh mục
        $totalCategories = Category::count();

        // Truy vấn để lấy tổng doanh thu và số lượng sản phẩm bán được theo từng sản phẩm
           $productSalesData = OrderItem::select('product_variant_id', 
                        DB::raw('SUM(order_items.quantity) as total_sold'), 
                        DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'))
    ->join('orders', 'order_items.order_id', '=', 'orders.id')  // Kết nối với bảng orders
    ->join('order_status', 'orders.status_id', '=', 'order_status.id')  // Kết nối với bảng order_status
    ->where('order_status.name', 'Hoàn tất')  // Chỉ tính các đơn hàng có trạng thái "Hoàn tất"
    ->groupBy('product_variant_id')
    ->orderByDesc('total_revenue')  // Sắp xếp theo doanh thu giảm dần
    ->get();
    
        // Lấy tên sản phẩm từ bảng `products` (hoặc bảng tương ứng)
        $products = Product::whereIn('id', $productSalesData->pluck('product_variant_id'))->get()->keyBy('id');
    
        // Chuyển đổi dữ liệu thành định dạng mà Chart.js có thể sử dụng
        $productNames = $productSalesData->map(function ($item) {
            // Truy xuất tên sản phẩm từ mối quan hệ đã eager loaded
            return $item->productVariant->product->name ?? 'Không có tên sản phẩm';
        });


        //số lượng doanh thu tỉnh
        $revenueAndSalesData = DB::table('order_address')
        ->join('orders', 'order_address.order_id', '=', 'orders.id')  // Join với bảng orders
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')  // Join với bảng order_items
        ->join('order_status', 'orders.status_id', '=', 'order_status.id')  // Join với bảng order_status qua status_id
        // Lọc chỉ lấy những đơn hàng có trạng thái 'completed'
        ->where('order_status.name', 'Hoàn tất')  
        ->select('order_address.province', 
                 DB::raw('SUM(order_items.quantity) as total_sales'),
                 DB::raw('SUM(order_items.quantity * order_items.price - orders.discount_amount + orders.shipping_fee) as total_revenue'))
        ->groupBy('order_address.province')
        ->get();


        $sanPham = ProductVariants::with('product') // Quan hệ với bảng products để lấy tên sản phẩm
        ->select('product_id', DB::raw('SUM(stock) as total_stock')) // Tính tổng số lượng tồn kho cho mỗi sản phẩm
        ->groupBy('product_id') // Nhóm theo product_id để tính tổng tồn kho cho mỗi sản phẩm
        ->get();
    

    

    
    
    
            
        $quantities = $productSalesData->pluck('total_sold');
        $revenues = $productSalesData->pluck('total_revenue');

        // Lấy khoảng thời gian bắt đầu và kết thúc
        $startDate = Carbon::parse($request->get('start_date', Carbon::now()->startOfMonth()->startOfDay()));
        $endDate = Carbon::parse($request->get('end_date', Carbon::now()->endOfMonth()->endOfDay()));

        // Lọc theo khoảng thời gian, trạng thái, phương thức thanh toán, và mã giảm giá
        $ordersQuery = Order::whereBetween('created_at', [$startDate, $endDate]);

        if ($request->has('status_id') && $request->get('status_id') !== null) {
            $ordersQuery->where('status_id', $request->get('status_id'));
        }

        if ($request->has('payment_method_id') && $request->get('payment_method_id') !== null) {
            $ordersQuery->where('payment_method_id', $request->get('payment_method_id'));
        }

        if ($request->has('coupon_id') && $request->get('coupon_id') != '') {
            $ordersQuery->where('coupon_id', $request->get('coupon_id'));
        }

        // Lấy dữ liệu đơn hàng và tính tổng doanh thu
        $orders = $ordersQuery->get();
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        // Doanh thu theo phương thức thanh toán
        $revenueByPaymentMethod = Payment_Methods::withSum('orders', 'total_amount')->get();

        // Doanh thu theo trạng thái đơn hàng
        $revenueByStatus = OrderStatus::withSum('orders', 'total_amount')->get();

        // Doanh thu theo mã giảm giá
        $revenueByCoupon = Coupon::withSum('orders', 'total_amount')->get();

        // Tồn kho
        $inventoryStats = ProductVariants::with('product', 'size')  // Eager load thông tin sản phẩm và kích cỡ
            ->whereNull('deleted_at')  // Lọc các sản phẩm chưa bị xóa (nếu có soft delete)
            ->get();

        // Chuyển đổi dữ liệu tồn kho
        $inventoryData = $inventoryStats->map(function ($inventory) {
            return [
                'product_name' => $inventory->product->name,
                'size_name' => $inventory->size->name,
                'stock' => $inventory->stock,
                'selled' => $inventory->selled,
                'price' => number_format($inventory->price),
                'weight' => number_format($inventory->weight, 2),
            ];
        });

        // Trạng thái đơn hàng
        $orderStatusCounts = Order::select('status_id', DB::raw('count(*) as count'))
            ->groupBy('status_id')
            ->get();

        // Danh sách trạng thái
        $statuses = OrderStatus::all();

        // Đơn hàng mới nhất
        $newOrders = Order::latest()
            ->with(['user', 'orderStatus', 'coupon'])
            ->paginate(5);

        // Top 5 sản phẩm bán chạy nhất
        $topProducts = OrderItem::select('product_variant_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_variant_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->with('productVariant.product')
            ->get();

        // Biểu đồ doanh thu theo ngày trong tháng
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $salesData = Order::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereHas('orderStatus', function ($query) {
            $query->where('name', 'Hoàn tất'); // Lọc chỉ lấy đơn hàng Hoàn tất
        })
        ->selectRaw('DATE(created_at) as date, SUM(total_amount - discount_amount + shipping_fee) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Chuyển đổi dữ liệu doanh thu thành định dạng cho Chart.js
        $dates = [];
        $totals = [];

        foreach ($salesData as $sale) {
            $dates[] = $sale->date;
            $totals[] = $sale->total;
        }

        if ($request->ajax()) {
            return response()->json([
                'totalRevenue' => number_format($totalRevenue, 2),
                'totalOrders' => $totalOrders,
            ]);
        }
        

        return view('admin.dashboard.bieudo', compact(
            'totalOrders',
            'totalProducts',
            'totalAdmins',
            'dates',
            'totals',
            'orderStatusCounts',
            'statuses',
            'newOrders',
            'topProducts',
            'totalRevenue',
            'startDate',
            'endDate',
            'orders',
            'revenueByPaymentMethod',
            'revenueByStatus',
            'revenueByCoupon',
            'doanhThu',
            'inventoryData',
            'totalCategories',
            'activeCouponsCount',
            'expiredCouponsCount',
            'productNames',
             'quantities', 
             'revenues',
             'revenueAndSalesData',
             'sanPham',
             'totalReviewsCount','sldh'
            
        ));
    }
}
