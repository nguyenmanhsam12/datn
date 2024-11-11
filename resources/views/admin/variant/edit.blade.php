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
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Thuộc tính</li>
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
                            <h3 class="card-title">Cập nhật thuộc tính</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('admin.variant.update',['id'=>$variant->id])}}">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                    name="name"
                                    value="{{$variant->product->name}}" 
                                    readonly
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Kích cỡ</label>
                                    <select id="inputStatus" name="size_id"
                                        class="form-control custom-select">
                                        <option>--Chọn kích cỡ--</option>
                                        @foreach ($allSize as $size)
                                            <option value="{{ $size->id }}" {{ $size->id == $variant->size_id ? 'selected' : '' }}>Size {{ $size->name }}
                                            </option>
                                        @endforeach
                                        
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Số lượng</label>
                                    <input type="text" class="form-control" name="stock"
                                    value="{{ $variant->stock }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="weight">Trọng lượng</label>
                                    <input type="text" class="form-control" name="weight"
                                    value="{{ $variant->weight }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Giá</label>
                                    <input type="text" class="form-control" name="price"
                                    value="{{ $variant->price }}"
                                    >
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
