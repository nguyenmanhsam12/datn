@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="mb-4">Chi tiết khiếu nại</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chi Tiết Đơn Hàng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Thông tin Đơn hàng</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã Đơn hàng:</strong> #{{ $complain->order_id }}</p>
                            <p><strong>Ngày Đặt hàng:</strong> {{ \Carbon\Carbon::parse($complain->order->created_at)->format('Y-m-d') }}</p>
                            @php
                                $finalTotal =
                                    $complain->order->total_amount - 
                                    $complain->order->discount_amount +
                                    $complain->order->shipping_fee ; 
                            @endphp
                            <p><strong>Tổng tiền đơn hàng:</strong> {{ number_format($finalTotal, 0, ',', '.') . ' VNĐ' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tên Khách hàng:</strong>{{ $complain->user->name }}</p>
                            <p><strong>Email:</strong>{{ $complain->user->email }}</p>
                            <p><strong>Số điện thoại:</strong>
                                {{ $complain->user->phone_number ?? $complain->order->orderAddress->phone_number }}</p>


                        </div>
                    </div>
                </div>


            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <strong>Thông tin khiếu nại</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('admin.comlaints.updateComplaints', ['id' => $complain->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                
                                <!-- Loại khiếu nại -->
                                <div class="form-group">
                                    <label for="complaint_type" class="form-label"><strong>Loại khiếu nại:</strong></label>
                                    <input type="text" id="complaint_type" name="complaint_type" class="form-control" 
                                           value="{{ $complain->complaint_type }}" readonly>
                                </div>
                
                                <!-- Mô tả chi tiết khiếu nại -->
                                <div class="form-group">
                                    <label for="complaint_details" class="form-label"><strong>Mô tả chi tiết khiếu nại:</strong></label>
                                    <textarea id="complaint_details" name="complaint_details" class="form-control" rows="5" readonly>{{ $complain->complaint_details }}</textarea>
                                </div>
                
                                <!-- Trạng thái khiếu nại -->
                                <div class="form-group">
                                    <label for="status" class="form-label"><strong>Trạng thái khiếu nại:</strong></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Chờ xử lý" {{ $complain->status == 'Chờ xử lý' ? 'selected' : '' }} 
                                            {{ $complain->status != 'Chờ xử lý' ? 'disabled' : '' }}>Chờ xử lý</option>
                                        <option value="Đang xử lý" {{ $complain->status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="Giải quyết thành công" {{ $complain->status == 'Giải quyết thành công' ? 'selected' : '' }}>Giải quyết thành công</option>
                                        <option value="Đã hủy" {{ $complain->status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                </div>
                
                                <!-- Hình ảnh -->
                                <div class="form-group">
                                    <label for="attachments" class="form-label"><strong>Hình ảnh:</strong></label>
                                    <div id="attachments">
                                        @foreach ($complain->attachments as $key => $img)
                                            <img src="{{ asset($img) }}" alt="Không có ảnh" height="100" width="100" class="me-2 mb-2">
                                        @endforeach
                                    </div>
                                </div>
                
                                <!-- Phản hồi cho người dùng -->
                                <div class="form-group">
                                    <label for="response" class="form-label"><strong>Phản hồi cho người dùng:</strong></label>
                                    <textarea id="response" name="response" class="form-control" rows="5">{{ $complain->response }}</textarea>
                                </div>
                
                                <!-- Nút cập nhật -->
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Cập nhật khiếu nại">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                


            </div>


        </section>
    </div>
@endsection
