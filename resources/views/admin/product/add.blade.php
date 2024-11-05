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
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">sản phẩm</li>
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
                            <h3 class="card-title">Thêm sản phẩm</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập tên sản phẩm"name="name">
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã sp</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="nhập mã"
                                        name="sku">
                                    @error('sku')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <textarea name="description" id="summernote" cols="10" rows="5" class="form-control"></textarea>

                                    @error('description')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">--Chọn danh mục--</option>
                                        @foreach ($allCategory as $cate)
                                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <select name="brand_id" class="form-control">
                                        <option value="">--Chọn thương hiệu--</option>
                                        @foreach ($allBrand as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh chính</label>
                                    <input type="file"name="image" class="form-control">
                                    @error('image')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh phụ</label>
                                    <input type="file" name="gallary[]" class="form-control" multiple>
                                    @error('gallary')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->






                            <!-- Chỗ chứa thuộc tính -->
                            <div id="tl_container">
                                <div class="col-md-12">

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thêm thuộc tính</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"
                                                    data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="attributes-container">
                                                <div class="attribute-group">
                                                    <div class="form-group">
                                                        <label for="inputStatus">Kích cỡ</label>
                                                        <select id="inputStatus" name="variants[0][size_id]"
                                                            class="form-control custom-select">
                                                            <option>--Chọn kích cỡ--</option>
                                                            @foreach ($allSize as $size)
                                                                <option value="{{ $size->id }}">Size
                                                                    {{ $size->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputStock">Số lượng</label>
                                                        <input type="text" id="inputStock" class="form-control"
                                                            name="variants[0][stock]">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputPrice">Giá</label>
                                                        <input type="text" id="inputPrice" class="form-control"
                                                            name="variants[0][price]">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>






                            </div>



                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                                <button type="button" class="btn btn-primary ml-auto" id="add-attribute">Thêm Thuộc
                                    tính</button>
                            </div>



                        </form>


                    </div>


                </div>
            </div>


            <!-- /.card -->

        </section>
    </div>
@endsection


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let attributeIndex = 1; // Để theo dõi số thứ tự của thuộc tính mới
            let selectedSizes = []; // Mảng lưu kích cỡ đã chọn

            document.getElementById('add-attribute').addEventListener('click', function() {
                const attributesContainer = document.getElementById('tl_container');

                // Tạo một div mới để chứa thuộc tính
                const newAttributeGroup = document.createElement('div');
                newAttributeGroup.classList.add('col-md-12'); // Cấu trúc div cha

                newAttributeGroup.innerHTML = `
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thêm thuộc tính</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool remove-attribute" title="Remove" style="color: red;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="attribute-group">
                            <div class="form-group">
                                <label for="inputStatus${attributeIndex}">Kích cỡ</label>
                                <select id="inputStatus${attributeIndex}" name="variants[${attributeIndex}][size_id]" class="form-control custom-select">
                                    <option>--Chọn kích cỡ--</option>
                                    @foreach ($allSize as $size)
                                        <option value="{{ $size->id }}">Size {{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputStock${attributeIndex}">Số lượng</label>
                                <input type="text" id="inputStock${attributeIndex}" class="form-control" name="variants[${attributeIndex}][stock]">
                            </div>
                            <div class="form-group">
                                <label for="inputPrice${attributeIndex}">Giá</label>
                                <input type="text" id="inputPrice${attributeIndex}" class="form-control" name="variants[${attributeIndex}][price]">
                            </div>
                        </div>
                    </div>
                </div>
            `;

                // Thêm thuộc tính mới vào container
                attributesContainer.appendChild(newAttributeGroup);
                attributeIndex++; // Tăng chỉ số thuộc tính

                // Lắng nghe sự kiện khi người dùng thay đổi kích cỡ
                const sizeSelect = newAttributeGroup.querySelector('select[name^="variants"]');
                sizeSelect.addEventListener('change', function() {
                    const selectedSize = this.value;

                    // Kiểm tra xem kích cỡ đã được chọn trong bất kỳ thuộc tính nào chưa
                    if (selectedSize) {
                        const isDuplicate = selectedSizes.some(size => size === selectedSize);

                        if (isDuplicate) {
                            alert('Kích cỡ này đã được chọn!');
                            this.value = ''; // Khôi phục giá trị đã chọn
                        } else {
                            // Nếu không có trùng lặp, thêm vào danh sách đã chọn
                            selectedSizes.push(selectedSize);
                        }
                    }
                });

                // Thêm sự kiện cho nút xóa
                newAttributeGroup.querySelector('.remove-attribute').addEventListener('click', function() {
                    const indexToRemove = selectedSizes.indexOf(sizeSelect.value);
                    if (indexToRemove !== -1) {
                        selectedSizes.splice(indexToRemove, 1); // Xóa kích cỡ khỏi mảng
                    }
                    attributesContainer.removeChild(newAttributeGroup);
                });
            });
        });
    </script>
    <script>
       $(function () {
            // Summernote
            $('#summernote').summernote()

        
        })
    </script>
@endpush
