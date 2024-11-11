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
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Người dùng</li>
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
                            <h3 class="card-title">Thêm người dùng </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.user.store') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên người dùng</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập họ và tên"name="name">
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email">
                                    @error('email')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập mật khẩu"name="password">
                                    @error('password')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập số điện thoại"name="phone_number">
                                    @error('phone_number')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Vai trò</label>
                                    <div class="checkbox-list">
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="role-{{ $role->id }}" name="role_id[]" value="{{ $role->id }}">
                                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
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


