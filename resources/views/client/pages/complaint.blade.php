@extends('client.components.default')

@section('content')
    <main class="main container border rounded shadow mt-4 mb-4 p-4">
        <h1 class="text-center mb-4">Hỗ trợ khiếu nại</h1>
        <p class="text-center mb-4">Nếu bạn gặp vấn đề với đơn hàng, hãy điền thông tin dưới đây để chúng tôi hỗ trợ bạn sớm
            nhất.</p>
        <form action="{{ route('complaintStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group ">
                <label for="order-id">Mã đơn hàng:</label>
                <input type="text" name="order_id" class="form-control" value="{{ $order->id }}" readonly>
            </div>
            <div class="form-group">
                <label for="order-date">Ngày đặt hàng:</label>
                <input type="date" name="order_date" class="form-control" required>
                @error('order')
                <div class="text-danger mt-1">{{ $message }}</div>
                 @enderror
            </div>
            <div class="form-group">
                <label for="complaint_type">Lý do khiếu nại:</label>
                <select name="complaint_type" class="form-control" required>
                    <option value="" disabled selected>Chọn lý do</option>
                    <option value="Hàng bị lỗi">Hàng bị lỗi</option>
                    <option value="Sản phẩm hư hỏng">Sản phẩm hư hỏng</option>
                    <option value="Giao hàng chậm">Giao hàng chậm</option>
                    <option value="Khác">Khác</option>
                </select>
                @error('complaint_type')
                <div class="text-danger mt-1">{{ $message }}</div>
                 @enderror
            </div>
            <div class="form-group">
                <label for="complaint_details">Mô tả chi tiết:</label>
                <textarea name="complaint_details" class="form-control" rows="5" placeholder="Nhập chi tiết vấn đề"></textarea>
                @error('complaint_details')
                <div class="text-danger mt-1">{{ $message }}</div>
                 @enderror
            </div>
            <div class="form-group">
                <label for="file">Đính kèm hình ảnh:(Nếu có)</label>
                <input type="file" id="file" name="attachments[]" class="form-control" accept="image/*" multiple>
                <div id="preview" class="mt-3 d-flex flex-wrap"></div>
            </div>
            <div class="form-actions text-end mt-4">
                <button class="btn btn-secondary ">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi khiếu nại</button>
            </div>
        </form>
        <div class="complaint__footer text-center mt-4 border-top pt-4">
            <p>Email: support@cuahang.com | Hotline: 1900 1234</p>
            <p>Chính sách hỗ trợ: Chúng tôi sẽ phản hồi khiếu nại sớm nhất có thể.</p>
        </div>
    </main>
@endsection

@push('script')
    {{-- đoạn mã preview ảnh --}}
    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview');

            // Xóa các preview cũ
            previewContainer.innerHTML = '';

            // Duyệt qua từng file và hiển thị preview
            Array.from(files).forEach((file) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.marginRight = '10px';
                        img.style.border = '1px solid #ccc';
                        img.style.borderRadius = '5px';
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file); // Đọc file và tạo URL
                }
            });
        });
    </script>

    
@endpush
