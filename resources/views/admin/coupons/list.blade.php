@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mã giảm giá</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Mã giảm giá</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            @can('create',App\Models\Coupon::class)
                <a href="{{route('admin.coupons.create')}}" class="btn btn-success mb-3">Thêm mới</a>
            @endcan

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mã giảm giá</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="list_coupon">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Tên mã giảm giá</th>
                                <th>Loại giảm giá</th>
                                <th>Giá trị mã</th>
                                <th>Số lượng mã chưa sử dụng</th>
                                <th>Số lượng mã đã sử dụng</th>
                                <th>Giá tiền đơn hàng</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $key => $coupon)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>{{ $coupon->discount_value }}</td>
                                    <td>{{ $coupon->usage_limit }}</td>
                                    <td>{{ $coupon->used_count }}</td>
                                    <td>{{ number_format($coupon->minimum_order_value,0,',','.').' VNĐ' }}</td>
                                    <td>{{ $coupon->end_date }}</td>
                                    <td>{{ $coupon->status  }}</td>
                                    <td>
                                        @can('view',App\Models\Coupon::class)
                                            <a href="{{ route('admin.coupons.edit',['id'=>$coupon->id]) }}" class="btn btn-warning">Sửa</a>
                                        @endcan
                                        @can('delete',App\Models\Coupon::class)
                                        <a href="{{ route('admin.coupons.delete',['id'=>$coupon->id]) }}" class="btn btn-danger"
                                            onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))"
                                            >Xóa</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection


@push('script')
    <script>
        let table = new DataTable('#list_coupon');
    </script>
@endpush