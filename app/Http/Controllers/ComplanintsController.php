<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Models\Complaints;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComplanintsController extends Controller
{
    public function complaints($orderId){
        $order = Order::find($orderId);
        return view('client.pages.complaint',compact('order'));
    }

    public function complaintStore(ComplaintRequest $request){
        $validatedData = $request->validated();
        // Lưu các ảnh phụ
        $attachments = [];
        // kiểm tra tồn tại và là 1 mảng
        if (isset($validatedData['attachments']) && is_array($validatedData['attachments'])) {
            foreach ($validatedData['attachments'] as $image) {
                if ($image) {

                    $attach_name = $image->getClientOriginalName();

                    $attach_extension = $image->getClientOriginalExtension();

                    $attach_name_extension = $attach_name . '_' . time() . '_' . $attach_extension;

                    // Di chuyển ảnh phụ và lưu đường dẫn tương đối
                    $image->move(public_path('complanints_images'), $attach_name_extension);
                    $attachments[] = 'complanints_images/' . $attach_name_extension; // Đường dẫn tương đối
                }
            }
        }


        Complaints::create([
            'order_id' => $validatedData['order_id'],
            'user_id' => Auth::user()->id,
            'complaint_details' => $validatedData['complaint_details'],
            'complaint_type' => $validatedData['complaint_type'],
            'status' => 'Chờ xử lý', // Mặc định trạng thái ban đầu
            'attachments' => json_encode($attachments), // Lưu danh sách file dưới dạng JSON
            'order_date' => $validatedData['order_date'],
        ]);

        return redirect()->route('myAccount')->with('success','Đã gửi khiếu nại');
    }

    //admin
    public function index(){
        $list_complaints = Complaints::orderBy('id','desc')->get();
        return view('admin.comlaints.list',compact('list_complaints'));
    }

    public function detailComplaints($id){
        $complain = Complaints::find($id);
        $complain->attachments = json_decode($complain->attachments);
        return view('admin.comlaints.detail',compact('complain'));
    }

    // cập nhật bằng js
    public function updateStatus(Request $request)
    {
        $data = $request->all();

        $complaintId = $data['complantId'];
        $newStatus = $data['status'];

        $complaint = Complaints::find($complaintId);

        if ($complaint) {
            // Kiểm tra trạng thái hợp lệ
            if ($newStatus == 'Giải quyết thành công') {
                $complaint->status = $newStatus;
                $complaint->save();

                return response()->json([
                    'message' => 'Cập nhật trạng thái khiếu nại thành công!',
                ], 200);
            }

            return response()->json([
                'error' => 'Trạng thái không hợp lệ hoặc đã được chọn!',
            ], 400);
        }

        return response()->json([
            'error' => 'Không tìm thấy khiếu nại!',
        ], 404);
    }



    
}
