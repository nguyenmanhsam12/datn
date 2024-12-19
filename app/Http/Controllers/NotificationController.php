<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetchNotifications(){
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(10) // Lấy 10 thông báo mới nhất
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request){
        $id = $request->input('id'); //id từ body

        if (!$id) {
            return response()->json(['error' => 'Notification ID is required'], 400);
        }

        $notification = Notification::find($id);

        if ($notification) {
            $notification->status = 'read';
            $notification->save();

            return response()->json(['message' => 'Thông báo đã đọc'], 200);
        }

        return response()->json(['error' => 'Thông báo không tồn tại'], 404);
    }
}
