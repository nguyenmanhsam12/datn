@extends('admin.layout.default')

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

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
                            <h3 class="card-title">Cập nhật người dùng </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.user.update',['id'=>$user->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên người dùng</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập họ và tên"name="name"
                                        value="{{ $user->name }}">
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                                    value="{{ $user->email }}"
                                    >
                                    @error('email')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập số điện thoại"name="phone_number"
                                        value="{{ $user->phone_number }}"
                                        >
                                    @error('phone_number')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mật khẩu</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="cập nhật mật khẩu"name="password"
                                        
                                        >
                                    @error('password')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Vai trò</label>
                                    <div class="select2-purple ">
                                        <select class="select2 form-control" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                        name="role_id[]"
                                        >
                                            <option>---Chọn vai trò---</option>
                                            @foreach ($roles as $role)
            
                                                <option value="{{ $role->id }}"
                                                    @if($user->roles->contains('id', $role->id)) selected @endif>
                                                {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
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

@push('script')

    <script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    </script>

    <script type="text/javascript">
        $(function() {
            if ($.fn.select2) {
                $('#select2').select2();
            } else {
                console.error("Select2 plugin is not loaded");
            }
        })
    </script>
@endpush
