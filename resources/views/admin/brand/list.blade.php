@extends('admin.layout.default')



@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thương hiệu</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Thương hiệu</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            @can('brand_add', App\Models\Brand::class)
                <a href="{{route('admin.brand.create')}}" class="btn btn-success mb-3">Thêm mới</a>
            @endcan

            @can('brand_listdeleted', App\Models\Brand::class)
                <a href="{{route('admin.brand.deleteAt')}}" class="btn btn-secondary mb-3">Thương hiệu đã xóa</a>
            @endcan

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thương hiệu</h3>

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
                    <table class="table table-striped projects" id="list_brand">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Tên thương hiệu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_brand as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @can('brand_edit',App\Models\Brand::class)
                                            <a href="{{route('admin.brand.edit',['id'=>$item->id])}}"class="btn btn-warning">Sửa</a>
                                        @endcan
                                        @can('brand_delete',App\Models\Brand::class)
                                            <a href="{{route('admin.brand.deleteBrand',['id'=>$item->id])}}"class="btn btn-danger"onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa</a>
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
        let table = new DataTable('#list_brand');

    </script>
@endpush