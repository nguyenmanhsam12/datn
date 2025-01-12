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

        /* Ẩn biến thể khi không có yêu cầu */
        .variant-row {
            display: none; /* Ẩn các dòng biến thể mặc định */
            background-color: #f8f9fa;
            transition: all 0.3s ease-in-out; /* Thêm hiệu ứng mượt mà khi hiển thị */
        }

        /* Bảng biến thể */
        .variants-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 20px;
        }

        /* Style cho tiêu đề bảng */
        .variants-table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 12px 15px;
        }

        /* Style cho các ô trong bảng */
        .variants-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        /* Hover hiệu ứng cho các dòng trong bảng */
        .variants-table tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Thêm viền mỏng cho các dòng đầu tiên của bảng */
        .variants-table tr:first-child {
            border-top: 2px solid #007bff;
        }

        /* Style cho cột "Hành động" */
        .variants-table td:last-child {
            text-align: center;
        }

        /* Style cho nút Sửa */
        /* Đặt hai nút ngang hàng và căn chỉnh đẹp */
        .btn-edit-variant,
        .btn-delete-variant {
            display: inline-block;
            margin: 0 5px; /* Thêm khoảng cách giữa các nút */
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none; /* Loại bỏ gạch chân */
            text-align: center;
            transition: all 0.3s ease;
        }

        /* Style nút Sửa */
        .btn-edit-variant {
            background-color: #ffc107; /* Màu vàng */
            color: #fff;
            border: none;
        }

        .btn-edit-variant:hover {
            background-color: #e0a800; /* Màu đậm hơn khi hover */
        }

        /* Style nút Xóa */
        .btn-delete-variant {
            background-color: #dc3545; /* Màu đỏ */
            color: #fff;
            border: none;
        }

        .btn-delete-variant:hover {
            background-color: #c82333; /* Màu đậm hơn khi hover */
            color: #fff;
        }


        .btn-edit-variant:hover {
            background-color: #e0a800;
            color: #fff;
        }

        /* Hiệu ứng khi hiển thị biến thể */
        .variant-row.show {
            display: table-row; /* Hiển thị lại khi người dùng nhấn "Xem biến thể" */
            background-color: #f8f9fa; /* Đảm bảo nền của các dòng biến thể không bị mất */
        }

        

        /* CSS cho phân trang */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 15px 0;
        }

        .pagination .page-link {
            color: #007bff;
            border: 1px solid #ddd;
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 4px;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination .active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .pagination .disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #ddd;
        }

        .search-form form {
            max-width: 400px;
            width: 100%;
        }

        .search-form input {
            border-radius: 4px;
        }

        .search-form button {
            white-space: nowrap;
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
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    @can('create', App\Models\Product::class)
                        <a href="{{ route('admin.product.create') }}" class="btn btn-success">Thêm mới</a>
                    @endcan
                    @can('viewTrashed', App\Models\Product::class)
                        <a href="{{ route('admin.product.deleteAt') }}" class="btn btn-secondary">Sản phẩm đã xóa</a>
                    @endcan
                </div>
            
                <div class="search-form">
                    <form action="" class="d-flex align-items-center">
                        <input type="text" name="search-product" class="form-control me-2" placeholder="Tìm kiếm sản phẩm">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
            
            </div>
            

            
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

                                    <td>{{ $pr->brand->name ?? 'Không có thương hiệu' }}</td>

                                    <td>
                                        @if ($pr->category->isEmpty())
                                            Không có danh mục
                                        @else
                                            @foreach ($pr->category as $cate)
                                                <span>{{ $cate->name }}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Nút Biến thể -->
                                        <button class="btn btn-primary btn-view-variants"
                                            data-product-id="{{ $pr->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Nút Sửa -->
                                        @can('view', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.edit', ['id' => $pr->id]) }}"
                                                class="btn btn-warning" title="Sửa">
                                                <i class="fas fa-edit"></i> <!-- Icon 'Sửa' -->
                                            </a>
                                        @endcan

                                        <!-- Nút Xóa -->
                                        @can('delete', [App\Models\Product::class, $pr->id])
                                            <a href="{{ route('admin.product.delete', ['id' => $pr->id]) }}"
                                                class="btn btn-danger" title="Xóa"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="fas fa-trash-alt"></i> <!-- Icon 'Xóa' -->
                                            </a>
                                        @endcan

                                        <!-- Nút Thêm thuộc tính -->
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#productVariant{{ $pr->id }}" title="Thêm thuộc tính">
                                            <i class="fas fa-plus"></i> <!-- Icon 'Thêm' -->
                                        </button>
                                    </td>

                                </tr>


                                <!-- Khu vực hiển thị biến thể khi nhấn nút "Xem biến thể" -->
                                <tr class="variant-row" id="variants-row-{{ $pr->id }}" style="display:none;">
                                    <td colspan="7">
                                        <table class="table table-striped" id="variants-table-{{ $pr->id }}">
                                            <thead>
                                                <tr>
                                                    <th>Kích cỡ</th>
                                                    <th>Số lượng</th>
                                                    <th>Chiều dài</th>
                                                    <th>Chiều rộng</th>
                                                    <th>Chiều cao</th>
                                                    <th>Giá</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variants-body-{{ $pr->id }}">
                                                <!-- Biến thể sẽ được tải vào đây thông qua fetch -->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <div class="modal fade" id="productVariant{{ $pr->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="addAttributeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAttributeModalLabel">Thêm thuộc tính</h5>
                                                <!-- Nút X (đóng modal) -->
                                                <button type="button" class="close" id="closeModal" aria-label="Close"
                                                    data-bs-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.variant.add') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" class="form-control"
                                                        name="product_id"value="{{ $pr->id }}">
                                                    <!-- Kích cỡ (Select) -->
                                                    <div class="form-group">
                                                        <label for="size">Kích cỡ</label>
                                                        <select class="form-control" id="size" name="size_id"required>
                                                            <option value="">--Chọn size--</option>
                                                            @foreach ($list_size as $size)
                                                                <option value="{{ $size->id }}">{{ $size->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('size_id')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Số lượng -->
                                                    <div class="form-group">
                                                        <label for="stock">Số lượng</label>
                                                        <input type="number" class="form-control" id="stock"
                                                            name="stock" placeholder="Nhập số lượng"required>
                                                        @error('stock')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Trọng lượng -->
                                                    <div class="form-group">
                                                        <label for="length">Chiều dài</label>
                                                        <input type="number" class="form-control" id="length"
                                                            name="length" placeholder="Nhập chiều dài" required>
                                                        @error('length')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="width">Chiều rộng</label>
                                                        <input type="number" class="form-control" id="width"
                                                            name="width" placeholder="Nhập chiều dài" required>
                                                        @error('width')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="height">Chiều cao</label>
                                                        <input type="number" class="form-control" id="height"
                                                            name="height" placeholder="Nhập chiều dài"required>
                                                        @error('height')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Giá -->
                                                    <div class="form-group">
                                                        <label for="price">Giá</label>
                                                        <input type="number" class="form-control" id="price"
                                                            name="price" placeholder="Nhập giá"required>
                                                        @error('price')
                                                            <div class="text-danger mt-3">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <!-- Nút Đóng -->
                                                <button type="button" class="btn btn-secondary" id="dismissModal"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <!-- Nút Lưu -->
                                                <button type="submit" class="btn btn-primary"
                                                    id="saveAttributes">Lưu</button>
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

            <!-- Hiển thị phân trang -->
            <div class="pagination-container">
                {{ $list_product->links() }} <!-- Đây là nơi sẽ hiển thị phân trang -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- Modal -->
@endsection

@push('script')


    
    

    <script>
        document.addEventListener('DOMContentLoaded', () => {



            const buttons = document.querySelectorAll('.btn-view-variants');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id'); // Lấy ID sản phẩm từ thuộc tính data-product-id
                    const rowId = `#variants-row-${productId}`; // Định danh của dòng hiển thị biến thể
                    const tableBodyId = `#variants-body-${productId}`; // Định danh của phần tbody để điền dữ liệu

                    // Kiểm tra xem biến thể đã được tải chưa
                    const row = document.querySelector(rowId);
                    if (row.style.display === 'table-row') {
                        // Nếu đã hiển thị, ẩn lại
                        row.style.display = 'none';
                    } else {
                        // Nếu chưa hiển thị, gửi yêu cầu fetch để lấy dữ liệu
                        fetch('{{ route('admin.variant.getVariants') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ product_id: productId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const tbody = document.querySelector(tableBodyId);
                            tbody.innerHTML = ''; // Làm trống tbody trước khi thêm dữ liệu mới

                            // Kiểm tra xem có biến thể không
                            if (data.length > 0) {
                                data.forEach(variant => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${variant.size.name}</td>
                                        <td>${variant.stock}</td>
                                        <td>${variant.length}</td>
                                        <td>${variant.width}</td>
                                        <td>${variant.height}</td>
                                        <td>${variant.price}</td>
                                        <td>
                                            <a href="/admin/variant/edit/${variant.id}" class="btn-edit-variant">Sửa</a>
                                            <a href="/admin/variant/delete/${variant.id}" class="btn-delete-variant">Xóa</a>
                                        </td>

                                    `;
                                    tbody.appendChild(row);
                                });

                                // Thêm sự kiện xác nhận xóa vào các nút "Xóa"
                                const deleteButtons = tbody.querySelectorAll('.btn-delete-variant');
                                deleteButtons.forEach(deleteButton => {
                                    deleteButton.addEventListener('click', function (event) {
                                        event.preventDefault(); // Ngăn chặn hành động mặc định
                                        const confirmDelete = confirm('Bạn có chắc chắn muốn xóa biến thể này không?');
                                        if (confirmDelete) {
                                            // Điều hướng đến URL để xóa
                                            window.location.href = this.href;
                                        }
                                    });
                                });
                            } else {
                                const noVariantsRow = document.createElement('tr');
                                noVariantsRow.innerHTML = '<td colspan="7">Không có biến thể</td>';
                                tbody.appendChild(noVariantsRow);
                            }

                        
                            // Hiển thị lại phần row chứa bảng biến thể
                            row.style.display = 'table-row';
                            row.classList.add('show'); // Thêm class 'show' để đảm bảo bảng biến thể được hiển thị
                        })
                        .catch(error => {
                            console.error('Có lỗi xảy ra khi tải biến thể:', error);
                            alert('Có lỗi xảy ra khi tải dữ liệu biến thể.');
                        });
                    }
                });
            });
        });
    </script>
@endpush
