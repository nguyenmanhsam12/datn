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
            @can('create', App\Models\Product::class)
                <a href="{{ route('admin.product.create') }}" class="btn btn-success mb-3">Thêm mới</a>
            @endcan
                <a href="{{ route('admin.product.deleteAt') }}" class="btn btn-secondary mb-3">Sản phẩm đã xóa</a>
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
                            @foreach ($list_product as $key => $pr)
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
                                    <td>
                                        @if($pr->category->isEmpty())
                                            Không có danh mục
                                        @else
                                            @foreach ($pr->category as $cate)
                                                <span>{{ $cate->name }}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @can('view', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.edit', ['id' => $pr->id]) }}"
                                                class="btn btn-warning">Sửa</a>
                                        @endcan
                                        @can('delete', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.delete', ['id' => $pr->id]) }}" class="btn btn-danger"
                                                onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa</a>
                                        @endcan
                                        <button type="button" class="btn btn-info" 
                                                data-bs-toggle="modal" data-bs-target="#productVariant{{$pr->id}}"
                                            >Thêm thuộc
                                            tính</button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="productVariant{{$pr->id}}" tabindex="-1" role="dialog" aria-labelledby="addAttributeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAttributeModalLabel">Thêm thuộc tính</h5>
                                                <!-- Nút X (đóng modal) -->
                                                <button type="button" class="close" id="closeModal" aria-label="Close"
                                                data-bs-dismiss="modal"
                                                >
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.variant.add') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" class="form-control" name="product_id"value="{{$pr->id}}">
                                                    <!-- Kích cỡ (Select) -->
                                                    <div class="form-group">
                                                        <label for="size">Kích cỡ</label>
                                                        <select class="form-control" id="size" name="size_id"required>
                                                            <option value="">--Chọn size--</option>                                                                
                                                            @foreach ($list_size as $size)
                                                                <option value="{{$size->id}}">{{$size->name}}</option>                                                                
                                                            @endforeach
                                                        </select>
                                                        @error("size_id")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                            
                                                    <!-- Số lượng -->
                                                    <div class="form-group">
                                                        <label for="stock">Số lượng</label>
                                                        <input type="number" class="form-control" id="stock" name="stock"
                                                            placeholder="Nhập số lượng"required >
                                                        @error("stock")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                            
                                                    <!-- Trọng lượng -->
                                                    <div class="form-group">
                                                        <label for="length">Chiều dài</label>
                                                        <input type="number" class="form-control" id="length" name="length"
                                                            placeholder="Nhập chiều dài" required>
                                                        @error("length")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="width">Chiều rộng</label>
                                                        <input type="number" class="form-control" id="width" name="width"
                                                            placeholder="Nhập chiều dài" required>
                                                            @error("width")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="height">Chiều cao</label>
                                                        <input type="number" class="form-control" id="height" name="height"
                                                            placeholder="Nhập chiều dài"required >
                                                            @error("height")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                            
                                                    <!-- Giá -->
                                                    <div class="form-group">
                                                        <label for="price">Giá</label>
                                                        <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá"required
                                                            >
                                                            @error("price")
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                               
                                            </div>
                                            <div class="modal-footer">
                                                <!-- Nút Đóng -->
                                                <button type="button" class="btn btn-secondary" id="dismissModal" data-bs-dismiss="modal">Đóng</button>
                                                <!-- Nút Lưu -->
                                                <button type="submit" class="btn btn-primary" id="saveAttributes">Lưu</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                     
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
