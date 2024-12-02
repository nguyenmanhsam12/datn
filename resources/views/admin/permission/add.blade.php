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
                            <li class="breadcrumb-item active">Quyền</li>
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
                            <h3 class="card-title">Thêm vai trò </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.permission.store') }}" method="POST">
                            @csrf
                           
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="" class="form-label">Tên quyền:</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label" >Mô tả quyền:</label>
                                    <input type="text" class="form-control" name="display_name" id="display_name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn module cha</label>
                                    <select name="parent_id" id="" class="form-control">
                                        <option value="0">--Chọn tên module--</option>
                                        @foreach($list_permission as $key => $moduleItem)
                                            <option value="{{ $moduleItem->id }}"> {{ $moduleItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                            </div>

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


