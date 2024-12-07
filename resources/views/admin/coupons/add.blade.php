@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

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
            <div class="card">
                <div class="card-header">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">Thêm mã giảm giá</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.coupons.storeCoupon') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Mã</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập tên mã giảm giá"name="code" value="{{ old('code') }}"required>
                                        @error('code')  
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Loại mã giảm giá</label>
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option value="">---Chọn loại giảm giá---</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
                                    </select>
                                    @error('discount_type')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="discount_value">Giá trị giảm giá</label>
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ old('discount_value') }}" step="0.01" required>
                                    @error('discount_type')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="form-group">
                                    <label for="minimum_order_value">Giá trị tối thiểu đơn hàng</label>
                                    <input type="number" class="form-control" id="minimum_order_value" name="minimum_order_value" value="{{ old('minimum_order_value') }}" step="0.01" required>
                                    @error('minimum_order_value')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="maximum_discount">Giá trị giảm tối đa</label>
                                    <input type="number" class="form-control" id="maximum_discount" name="maximum_discount" value="{{ old('maximum_discount') }}" step="0.01" required>
                                    @error('maximum_discount')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="form-group">
                                    <label for="end_date">Ngày hết hạn</label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                    
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Đã hết hạn</option>
                                    </select>
                                    @error('status')
                                            <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
