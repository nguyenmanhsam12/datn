@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thuộc tính</h1>
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
            <a href="{{ route('admin.variant.deleteAt') }}" class="btn btn-secondary mb-3">Thuộc tính đã xóa</a>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thuộc tính</h3>

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
                    <table class="table table-striped projects" id="list_variant">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>Tên sản phẩm</th>
                                <th>Kích cỡ</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($softVariant as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->size->name}}</td>
                                    <td>{{$item->stock}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>

                                        @can('restore',App\Models\ProductVariants::class)
                                            <a href="{{route('admin.variant.restore',['id'=>$item->id])}}"class="btn btn-warning">Khôi phục</a>
                                        @endcan
                                       
                                        @can('forceDelete',App\Models\ProductVariants::class)
                                            <a href="{{route('admin.variant.forceDeleteVariant',['id'=>$item->id])}}"class="btn btn-danger"onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa vĩnh viễn</a>
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
        let table = new DataTable('#list_variant');

    </script>
@endpush