@extends('client.components.default')

@section('content')
    <main class="main container border rounded shadow mt-4 mb-4 p-4">
        <h1 class="text-center mb-4">Chi tiết khiếu nại</h1>
        <form action="{{ route('updateComplaintsImage',['orderId'=>$complaint->order_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order-id">Mã đơn hàng:</label>
                <input type="text" name="order_id" class="form-control" value="{{ $complaint->order_id }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="order-date">Ngày đặt hàng:</label>
                <input type="date" name="order_date" value="{{ \Carbon\Carbon::parse($complaint->order->created_at)->format('Y-m-d') }}" class="form-control" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="complaint_type">Lý do khiếu nại:</label>
                <input type="text" class="form-control" value="{{ $complaint->complaint_type }}" readonly>
                
            </div>
            <div class="form-group mb-3">
                <label for="complaint_type">Trạng thái khiếu nại:</label>
                <input type="text" class="form-control" value="{{ $complaint->status }}" readonly>
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
            @if ($complaint->status == 'Chờ xử lý')
                <div class="form-actions d-flex justify-content-between align-items-center mt-4">
                    
                        <button type="button" class="btn btn-danger" id="cancel-complaint-btn"
                        data-order-id = "{{ $complaint->order_id }}"    
                        >Hủy khiếu nại</button>
                    
                    <div>
                        <a href="{{ route('myAccount') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật khiếu nại</button>
                    </div>
                </div>
            @else
                <div class="form-actions">
                    <div class="text-end">
                        <a href="{{ route('myAccount') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật khiếu nại</button>
                    </div>
                </div>
            @endif          
        </form>
        <div class="complaint__footer text-center mt-4 border-top pt-4">
            <p>Email: support@cuahang.com | Hotline: 1900 1234</p>
            <p>Chính sách hỗ trợ: Chúng tôi sẽ phản hồi khiếu nại sớm nhất có thể.</p>
        </div>
    </main>
@endsection

@push('script')

{{-- hủy khiếu nại --}}
<script>
    document.getElementById('cancel-complaint-btn').addEventListener('click', function () {
        const order_id = document.getElementById('cancel-complaint-btn').getAttribute('data-order-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: 'Bạn sẽ không thể khôi phục khiếu nại này!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hủy khiếu nại',
            cancelButtonText: 'Quay lại'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('complaintsDelete') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: order_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Đã hủy!',
                            'Khiếu nại của bạn đã được hủy.',
                            'success'
                        ).then(() => {
                            window.location.href = "{{ route('myAccount') }}";
                        });
                    } else {
                        Swal.fire(
                            'Thất bại!',
                            'Có lỗi xảy ra, vui lòng thử lại.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Lỗi!',
                        'Không thể hủy khiếu nại. Vui lòng thử lại sau.',
                        'error'
                    );
                });
            }
        });
    });
</script>

@endpush
