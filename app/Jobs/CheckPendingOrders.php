<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckPendingOrders implements ShouldQueue
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
        try {
            // Thời gian giới hạn là 5 phút trước
            $timeLimit = Carbon::now()->subMinutes(5);  

            // Lấy các đơn hàng có trạng thái 'pending' và được tạo từ hơn 5 phút trước
            $orders = Order::where('payment_status', 'pending')
                           ->where('status_id',1)
                           ->where('payment_method_id','!=',1)
                           ->where('created_at', '<', $timeLimit)
                           ->get();
        
            // Kiểm tra các đơn hàng này
            foreach ($orders as $order) {

                Log::info("Order ID: {$order->id} is pending and older than 5 minutes. Updating status...");

                // Cập nhật trạng thái của đơn hàng
                $order->payment_status = 'canceled';
                $order->status_id = 6;
                 

                $transaction = $order->transaction;
                if ($transaction) {
                    $transaction->status = 'canceled';
                    $transaction->save();
                    Log::info("id của order {$order->id}");
                }else{
                    Log::info("Không tìm thấy transaction");
                }

                $order->save();
            }
        
            Log::info("CRONJOB COMPLETED");
        } catch (\Exception $e) {
            Log::error('Error during cron job: ' . $e->getMessage());
        }
    }
}
