@extends('client.components.default')

@section('content')
    <main class="main container border rounded shadow mt-4 mb-4 p-4">
        <h1 class="text-center mb-4">Chi tiết khiếu nại</h1>
        <p class="text-center mb-4">Nếu bạn gặp vấn đề với đơn hàng, hãy điền thông tin dưới đây để chúng tôi hỗ trợ bạn sớm
            nhất.</p>
        <form action="{{ route('updateComplaintsImage',['orderId'=>$complaint->order_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order-id">Mã đơn hàng:</label>
                <input type="text" name="order_id" class="form-control" value="{{ $complaint->order_id }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="complaint_type">Lý do khiếu nại:</label>
                <input type="text" class="form-control" value="{{ $complaint->complaint_type }}" readonly>
                @error('complaint_type')
                <div class="text-danger mt-1">{{ $message }}</div>  
                 @enderror
            </div>
            <div class="form-group mb-3">
                <label for="complaint_type">Trạng thái khiếu nại:</label>
                <input type="text" class="form-control" value="{{ $complaint->status }}" readonly>
                @error('complaint_type')
                <div class="text-danger mt-1">{{ $message }}</div>
                 @enderror
            </div>

            <div class="form-group mb-3">
                <label for="complaint_details">Mô tả chi tiết:</label>
                <textarea name="complaint_details" class="form-control" rows="5" placeholder="Nhập chi tiết vấn đề" readonly>{{ $complaint->complaint_details}}</textarea>
                @error('complaint_details')
                <div class="text-danger mt-1">{{ $message }}</div>
                 @enderror
            </div>
            <div class="form-group mb-3">
                <label for="file">Đính kèm hình ảnh</label>
                <input type="file" id="file" name="attachments[]" class="form-control" accept="image/*" multiple>
                @foreach($complaint->attachments as $key => $img)
                    <img src="{{ asset($img) }}" alt="Không có tệp tính kèm" width="100" height="100" >
                @endforeach
            </div>
            <div class="form-group mb-3">
                <label for="complaint_details">Phản hồi từ chăm sóc khách hàng:</label>
                <textarea name="complaint_details" class="form-control" rows="5" placeholder="Phản hồi từ phía shop" readonly>{{ $complaint->response}}</textarea>
            </div>
            <div class="form-actions text-end mt-4">
                <a href="{{ route('myAccount') }}" class="btn btn-secondary ">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhập khiếu nại</button>
            </div>
        </form>
        <div class="complaint__footer text-center mt-4 border-top pt-4">
            <p>Email: support@cuahang.com | Hotline: 1900 1234</p>
            <p>Chính sách hỗ trợ: Chúng tôi sẽ phản hồi khiếu nại sớm nhất có thể.</p>
        </div>
    </main>
@endsection


