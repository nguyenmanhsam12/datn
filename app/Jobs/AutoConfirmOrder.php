<?php

namespace App\Jobs;

use App\Events\OrderConfirm;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoConfirmOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $timeLimit = Carbon::now()->subMinutes(5);  //thời gian hiện tại với 5 phút trước

        $orders = Order::where('status_id',4)
            ->where('created_at', '<', $timeLimit) // Sử dụng updated_at
            // giúp trả về các bản ghi không có quản hệ
            ->where(function ($query) {
                $query->whereDoesntHave('complaint') // Không có khiếu nại
                      ->orWhereHas('complaint', function ($subQuery) {
                          $subQuery->whereIn('status', ['Giải quyết thành công', 'Đã hủy']); // Có khiếu nại nhưng đã giải quyết hoặc hủy
                      });
            })
            ->get();

        

        foreach ($orders as $order) {
            // Cập nhật trạng thái đơn hàng
            $order->update([
                'status_id' => 5, // Trạng thái xác nhận tự động
                'payment_status' => 'paid',
            ]);

            broadcast(new OrderConfirm($order));

            Log::info("Order ID {$order->id} auto-confirmed after 5 minutes.");
        }
    }
}
