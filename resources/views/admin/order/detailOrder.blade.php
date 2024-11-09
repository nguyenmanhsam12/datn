@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="mb-4">Chi tiết Đơn hàng #12345</h1>
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
                            <p><strong>Mã Đơn hàng:</strong> #12345</p>
                            <p><strong>Ngày Đặt hàng:</strong> 10/11/2023</p>
                            <p><strong>Hình Thức Thanh Toán:</strong> Thanh Toán Online</p>
                            <p><strong>Trạng thái:</strong>
                                <span class="badge badge-warning text-white">Chờ xử lý</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tên khách hàng:</strong> Nguyễn Văn A</p>
                            <p><strong>Email:</strong> nguyenvana@example.com</p>
                            <p><strong>Số điện thoại:</strong> 0123456789</p>
                            <p><strong>Địa Chỉ:</strong> 19C Hoàng Diệu, Điên Biên, Ba Đình, Hà Nội</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm trong đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Danh sách Sản phẩm</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sản phẩm A</td>
                                <td>2</td>
                                <td>200,000 đ</td>
                                <td>400,000 đ</td>
                            </tr>
                            <tr>
                                <td>Sản phẩm B</td>
                                <td>1</td>
                                <td>300,000 đ</td>
                                <td>300,000 đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tổng cộng</strong></td>
                                <td><strong>700,000 đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cập nhật trạng thái đơn hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Cập nhật Trạng thái Đơn hàng</strong>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="orderStatus">Trạng thái</label>
                            <select id="orderStatus" class="form-control">
                                <option value="pending">Chờ xử lý</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Hủy bỏ</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
    </div>
    </section>
@endsection
