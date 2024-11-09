@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản Lý Đơn Hàng</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quản Lý Đơn Hàng</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Bảng đơn hàng -->
            <table class="table table-bordered mt-4">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Khách Hàng</th>
                        <th>Sản Phẩm</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mẫu đơn hàng -->
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>Bàn Phím Cơ</td>
                        <td>2024-11-08</td>
                        <td>2,000,000₫</td>
                        <td>
                            <select class="form-control">
                                <option value="pending">Đang xử lý</option>
                                <option value="shipping">Đang giao hàng</option>
                                <option value="delivered">Đã giao</option>
                                <option value="canceled">Đã hủy</option>
                            </select>
                        </td>
                        <td>
                            <a href="{{route('admin.order.detail',['id'=>1])}}" class="btn btn-success btn-sm">Xem Chi Tiết</a>
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>
                    <!-- Thêm đơn hàng khác tại đây -->
                </tbody>
            </table>

        </section>
        <!-- /.content -->
    </div>
@endsection
