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
                                    <td>{{ $pr->brand->name }}</td>
                                    <td>{{ $pr->category->name }}</td>
                                    <td>
                                        @can('view', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.edit', ['id' => $pr->id]) }}"
                                                class="btn btn-warning">Sửa</a>
                                        @endcan
                                        @can('delete', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.delete', ['id' => $pr->id]) }}" class="btn btn-danger"
                                                onclick="return(confirm('Bạn có chắc chắn muốn xóa không'))">Xóa</a>
                                        @endcan
                                        <button type="button" class="btn btn-info" id="openAddAttributeModal">Thêm thuộc
                                            tính</button>
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
    <div class="modal fade" id="addAttributeModal" tabindex="-1" role="dialog" aria-labelledby="addAttributeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAttributeModalLabel">Thêm thuộc tính</h5>
                    <!-- Nút X (đóng modal) -->
                    <button type="button" class="close" id="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addAttributeForm">
                        <!-- Kích cỡ (Select) -->
                        <div class="form-group">
                            <label for="size">Kích cỡ</label>
                            <select class="form-control" id="size" name="size">
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                        </div>

                        <!-- Số lượng -->
                        <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                placeholder="Nhập số lượng" required>
                        </div>

                        <!-- Trọng lượng -->
                        <div class="form-group">
                            <label for="weight">Trọng lượng (kg)</label>
                            <input type="number" class="form-control" id="weight" name="weight"
                                placeholder="Nhập trọng lượng" required>
                        </div>

                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Nút Đóng -->
                    <button type="button" class="btn btn-secondary" id="dismissModal">Đóng</button>
                    <!-- Nút Lưu -->
                    <button type="button" class="btn btn-primary" id="saveAttributes">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let table = new DataTable('#list_product');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalBtns = document.querySelectorAll('.btn-info'); // Tất cả các nút mở modal
            const modal = document.getElementById('addAttributeModal'); // Modal
            const closeModalBtn = document.getElementById('closeModal'); // Nút đóng (X)
            const dismissModalBtn = document.getElementById('dismissModal'); // Nút đóng (Đóng)

            // Hàm mở modal
            function openModal() {
                modal.classList.add('show'); // Thêm lớp 'show' để modal hiển thị
                modal.style.display = 'block'; // Hiển thị modal
            }

            // Hàm đóng modal
            function closeModal() {
                modal.classList.remove('show'); // Loại bỏ lớp 'show'
                modal.style.display = 'none'; // Ẩn modal
            }

            // Gắn sự kiện mở modal cho tất cả các nút "Thêm thuộc tính"
            openModalBtns.forEach(function(btn) {
                btn.addEventListener('click', openModal);
            });

            // Gắn sự kiện đóng modal vào nút "X" và nút "Đóng"
            closeModalBtn.addEventListener('click', closeModal);
            dismissModalBtn.addEventListener('click', closeModal);

            // Đóng modal khi nhấn bên ngoài modal
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
@endpush
