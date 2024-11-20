{{-- @extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sản phẩm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <a href="{{route('admin.product.create')}}" class="btn btn-success mb-3">Thêm mới</a>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sản phẩm</h3>

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
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Mã SP</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th>Thao tác</th>
                            </tr>   
                        </thead>
                        <tbody>
                            @foreach ($list_product as $key => $pr)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$pr->name}}</td>
                                    <td>
                                        <img src="{{$pr->image}}" alt="" width="100" height="100">
                                    </td>
                                    <td>{{$pr->sku}}</td>
                                    <td>{{$pr->brand->name}}</td>
                                    <td>{{$pr->category->name}}</td>
                                    <td>
                                        <a href="{{route('admin.product.edit',['id'=>$pr->id])}}" class="btn btn-warning">Sửa</a>
                                        <a href="{{route('admin.product.delete',['id'=>$pr->id])}}" class="btn btn-danger" onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa</a>
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
@endsection --}}
