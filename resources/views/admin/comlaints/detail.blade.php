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
                            <p><strong>Ngày Đặt hàng:</strong> {{ $complain->order->created_at }}</p>
                            @php 
                                $finalTotal = $complain->order->discount_amount + $complain->order->shipping_fee + $complain->order->total_amount
                            @endphp
                            <p><strong>Tổng tiền đơn hàng:</strong> {{ number_format($finalTotal,0,',','.').' VNĐ' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tên Khách hàng:</strong>{{ $complain->user->name }}</p>
                            <p><strong>Email:</strong>{{ $complain->user->email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $complain->user->phone_number ?? $complain->order->orderAddress->phone_number }}</p>
                            
                        
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
                            <p><strong>Loại khiếu nại:</strong> #{{ $complain->complaint_type }}</p>
                            <p><strong>Mô tả chi tiết khiếu nại:</strong> {{ $complain->complaint_details }}</p>
                            <p><strong>Trạng thái khiếu nại:</strong> {{ $complain->status }}</p>
                            <p><strong>Hình ảnh (nếu có):</strong>
                                @foreach ($complain->attachments as $item)
                                    <img src=" {{ asset($item)  }}" alt="Ảnh bị lỗi" width="100" height="100">
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>

                
            </div>

         
    </div>
    </section>
@endsection
