@extends('admin.layout.default')

@push('styles')
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Sản phẩm đã xóa</h1>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm đã xóa</h3>
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
                    <table class="table table-striped projects" id="list_product">
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
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($softProduct as $key => $pr)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $pr->name }}</td>
                                    <td>
                                        <img src="{{ $pr->image }}" alt="" width="100" height="100">
                                    </td>
                                    <td>{{ $pr->sku }}</td>
                                    @if($pr->brand_id)
                                        <td>{{ $pr->brand->name }}</td>
                                    @else
                                        Không có thương hiệu
                                    @endif
                                    @if($pr->category_id)
                                        <td>{{ $pr->category->name }}</td>
                                    @else
                                        <td>
                                            Không có danh mục
                                        </td>
                                    @endif
                                    <td>    
                                        @can('restore', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.restore', ['id' => $pr->id]) }}"
                                                class="btn btn-warning">Khôi phục</a>
                                        @endcan
                                        @can('forceDelete', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.forceDeleteProduct', ['id' => $pr->id]) }}" class="btn btn-danger"
                                                onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa vĩnh viễn</a>
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
    <!-- Modal -->
    
@endsection

@push('script')
    <script>
        let table = new DataTable('#list_product');
    </script>
    
@endpush
