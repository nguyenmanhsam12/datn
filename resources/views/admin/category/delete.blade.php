@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh mục đã xóa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh mục</li>
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
                    <h3 class="card-title">Danh mục</h3>

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
                    <table class="table table-striped projects" id="list_category">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Tên danh mục</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($softCategory as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @can('restore',App\Models\Category::class)
                                            <a href="{{route('admin.category.restore',['id'=>$item->id])}}"class="btn btn-warning">Khôi phục</a>
                                        @endcan
                                        @can('forceDelete',App\Models\Category::class)
                                            <a href="{{route('admin.category.forceDeleteCategory',['id'=>$item->id])}}"class="btn btn-danger"onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa vĩnh viễn</a>
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
        let table = new DataTable('#list_category');

    </script>
@endpush