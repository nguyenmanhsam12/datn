<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Payment_Methods;

use Illuminate\Http\Request;use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // đếm số lượng
        $totalOrders = Order::count();
        $totalProducts = Product::count(); 
        $totalAdmins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->count();
         // dd($request->all());   
         
         
        // Lấy ngày bắt đầu và ngày kết thúc 
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        // lọc theo tg
        $ordersQuery = Order::whereBetween('created_at', [$startDate, $endDate]);

                // lọc theo trạng t
            if ($request->has('status_id') && $request->get('status_id') !== null) {
                    $ordersQuery->where('status_id', $request->get('status_id'));
                }
                // lọc theo pppt
            if ($request->has('payment_method_id') && $request->get('payment_method_id') !== null) {
                    $ordersQuery->where('payment_method_id', $request->get('payment_method_id'));
                }
                //lọc theo mã giảm giá
                if ($request->has('coupon_id') && $request->get('coupon_id') != '') {
                    $ordersQuery->where('coupon_id', $request->get('coupon_id'));
                }



             // dlay du lieu đoen hang
            $orders = $ordersQuery->get();
            //  tổng doanh thu
            $totalRevenue = $orders->sum('total_amount');
            // tổng số đơn hàng
            $totalOrders = $orders->count();
            // Doanh thu theo phương thức thanh toán
            $revenueByPaymentMethod = Payment_Methods::withSum('orders', 'total_amount')->get();
            // Doanh thu theo trạng thái đơn hàng
            $revenueByStatus = OrderStatus::withSum('orders', 'total_amount')->get();
            // Doanh thu theo mã giảm giá
            $revenueByCoupon = Coupon::withSum('orders', 'total_amount')->get();



         //  trạng thái đơn hàng
         $orderStatusCounts = Order::select('status_id', \DB::raw('count(*) as count'))
         ->groupBy('status_id')
         ->get();

            // danh sách trạng thái
         $statuses = OrderStatus::all();


            $newOrders = Order::latest()  // Sắp xếp theo thời gian tạo, đơn hàng mới nhất lên trên
            ->with(['user', 'orderStatus', 'coupon']) // Eager loading các quan hệ cần thiết
            ->paginate(5); // Phân trang 5 đơn hàng mỗi trang

             // top5 sp b chay
        $topProducts = OrderItem::select('product_variant_id', \DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('product_variant_id')
        ->orderByDesc('total_sold')  // theo số lượng bán
        ->limit(5)  
        ->with('productVariant.product')  
        ->get();


        // biểu đồ donah thu các ngày trong thnasg
         // Lấy tháng hiện tại hoặc tháng được chọn
         $month = $request->get('month', Carbon::now()->month);
         $year = $request->get('year', Carbon::now()->year);
 
         // Lấy tổng doanh thu theo ngày trong tháng
         $salesData = Order::whereYear('created_at', $year)
             ->whereMonth('created_at', $month)
             ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
             ->groupBy('date')
             ->orderBy('date')
             ->get();
 
         // Chuyển đổi dữ liệu thành định dạng mà Chart.js có thể sử dụng
         $dates = [];
         $totals = [];
         
         foreach ($salesData as $sale) {
             $dates[] = $sale->date;
             $totals[] = $sale->total;
         }


         if ($request->ajax()) {
            return response()->json([
                'totalRevenue' => number_format($totalRevenue, 2),
                'totalOrders' => $totalOrders
            ]);
        }
        return view('admin.dashboard.bieudo',
         compact(
                    'totalOrders',
                    'totalProducts', 
                    'totalAdmins',
                    'dates', 
                    'totals',
                    'orderStatusCounts',
                     'statuses','newOrders','topProducts', 'totalRevenue', 
                     'totalOrders', 'startDate', 
            'endDate',
            'orders','revenueByPaymentMethod', 
            'revenueByStatus', 
            'revenueByCoupon'
                
                ));
        
    }
    
}
