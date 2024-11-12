<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment_Methods;
use App\Models\OrderStatus;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
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
        // Trả về view 
        return view('admin.statistical.views', compact(
            'totalRevenue', 
            'totalOrders', 
            'revenueByPaymentMethod', 
            'revenueByStatus', 
            'revenueByCoupon',
            'startDate', 
            'endDate',
            'orders'    
        ));
    }
   public function bieuDo(Request $request){
    return view('admin.statistical.bieudo');

   }
}
