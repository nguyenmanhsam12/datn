<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Models\Complaints;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComplanintsController extends Controller
{
    public function complaintsDelete(Request $request){
        $orderId = $request->input('order_id');

        // Tìm khiếu nại theo mã đơn hàng
        $complaint = Complaints::where('order_id', $orderId)->first();
        
        if ($complaint) {
            $complaint->delete(); // Xóa khiếu nại
            return response()->json(['success' => true, 'message' => 'Khiếu nại đã được hủy']);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy khiếu nại']);
    }

    public function complaints($orderId){
        $order = Order::find($orderId);
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.complaint',compact('order','list_brand','list_category'));
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

    public function complaintsDetail($orderId){
        $complaint = Complaints::where('order_id',$orderId)->first();
        $complaint->attachments = json_decode($complaint->attachments);
        $list_brand = Brand::orderBy('id','desc')->get();
        $list_category = Category::orderBy('id','desc')->get();
        return view('client.pages.detail_comlaint',compact('complaint','list_brand','list_category'));
    }

    public function updateComplaintsImage(Request $request , $orderId){
        
        $data = $request->only('attachments');

        $complaint = Complaints::where('order_id',$orderId)->first();

        $attachments = json_decode($complaint->attachments,true) ?? [];

        // Kiểm tra xem có file đính kèm mới không
        if ($request->hasFile('attachments')) {
            // Xóa toàn bộ ảnh cũ nếu có
            foreach ($attachments as $img) {
                if (file_exists(public_path($img))) {
                    unlink(public_path($img));
                }
            }

            $attachments = [];

            // kiểm tra tồn tại và là 1 mảng
            if (isset($data['attachments']) && is_array($data['attachments'])) {
                foreach ($data['attachments'] as $image) {
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
           
        }

        // Lưu các thay đổi
        $complaint->attachments = json_encode($attachments);
        $complaint->save();

        return redirect()->back()->with('success', 'Cập nhật hình ảnh thành công!');

        

    }

    //admin backend
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

    // cập nhâp form thường
    public function updateComplaints(Request $request, $id)
    {
        $data = $request->all();

        // Lấy khiếu nại dựa vào ID
        $complaint = Complaints::findOrFail($id);
        
        // lấy ra đơn hàng
        $order = Order::find($complaint->order_id);

        $currentStatus = $complaint->status;    //lưu trạng thái khiếu nại ban đầu

        $newStatus = $data['status'] ?? $currentStatus; // Nếu không có trạng thái mới, giữ nguyên trạng thái hiện tại

        $response = $data['response'] ?? $complaint->response; // Nếu không có phản hồi mới, giữ nguyên phản hồi hiện tại

        // Danh sách trạng thái yêu cầu phản hồi
        $statusesRequireResponse = ['Giải quyết thành công', 'Đã hủy'];

        // Kiểm tra điều kiện chuyển đổi trạng thái
        if ($currentStatus === 'Chờ xử lý' && $newStatus === 'Đang xử lý') {
            // Cho phép cập nhật trạng thái, phản hồi không bắt buộc
            $complaint->status = $newStatus;
            $complaint->response = $response; // Lưu phản hồi nếu có

        } elseif ($currentStatus === 'Đang xử lý' && in_array($newStatus,$statusesRequireResponse)) {
            // Yêu cầu phản hồi khi chuyển sang trạng thái hoàn tất hoặc hủy
            if (in_array($newStatus, $statusesRequireResponse) && empty($response)) {
                return redirect()->back()->with('error', 'Vui lòng nhập phản hồi trước khi cập nhật trạng thái này.');
            }

           
            $complaint->status = $newStatus;
            $complaint->response = $response;
            
            $order->save();

        } elseif ($currentStatus === $newStatus) {
            // Cập nhật phản hồi mà không thay đổi trạng thái
            $complaint->response = $response;
        } else {
            // Trạng thái không hợp lệ
            return redirect()->back()->with('error', 'Cập nhật trạng thái không hợp lệ!');
        }

        // Lưu cập nhật vào cơ sở dữ liệu
        $complaint->save();

        // Chuyển hướng lại với thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    



    
}
