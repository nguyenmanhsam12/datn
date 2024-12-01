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
                                        placeholder="nhập tên sản phẩm"name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã sp</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="nhập mã"
                                        name="sku" value="{{ old('sku') }}">
                                    @error('sku')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả ngắn</label>
                                    <textarea name="description" id="" cols="10" rows="5" class="form-control">{{ old('description') }}</textarea>

                                    @error('description')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description_text">Mô tả dài</label>
                                    <textarea name="description_text" id="summernote" cols="10" rows="5" class="form-control">{{ old('description_text') }}</textarea>
                                    @error('description_text')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">--Chọn danh mục--</option>
                                        @foreach ($allCategory as $cate)
                                            <option value="{{ $cate->id }}" {{ old('category_id') == $cate->id ? 'selected' : '' }}>{{ $cate->name }}</option>
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
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : ''  }}>{{ $brand->name }}</option>
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
                                @if(old('variants'))
                                    @foreach(old('variants') as $index => $variant)
                                        {{-- {{ dd($variant) }} --}}
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Thêm thuộc tính</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-tool remove-attribute" style="color: red;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="inputStatus{{ $index }}">Kích cỡ</label>
                                                    <select id="inputStatus{{ $index }}" name="variants[{{ $index }}][size_id]" class="form-control size-select">
                                                        <option value="">--Chọn kích cỡ--</option>
                                                        @foreach ($allSize as $size)
                                                            <option value="{{ $size->id }}" 
                                                                {{ old("variants.$index.size_id") == $size->id ? 'selected' : '' }}
                                                                >                                                                
                                                                Size {{ $size->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error("variants.$index.size_id")
                                                        <div class="text-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputStock{{ $index }}">Số lượng</label>
                                                    <input type="text" id="inputStock{{ $index }}" 
                                                        class="form-control" 
                                                        name="variants[{{ $index }}][stock]" 
                                                        value="{{ old("variants.$index.stock") }}">
                                                    @error("variants.$index.stock")
                                                        <div class="text-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="weight{{ $index }}">Trọng lượng</label>
                                                    <input type="text" id="weight{{ $index }}" 
                                                        class="form-control" 
                                                        name="variants[{{ $index }}][weight]" 
                                                        value="{{ old("variants.$index.weight") }}">
                                                    @error("variants.$index.weight")
                                                        <div class="text-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPrice{{ $index }}">Giá</label>
                                                    <input type="text" id="inputPrice{{ $index }}" 
                                                        class="form-control" 
                                                        name="variants[{{ $index }}][price]" 
                                                        value="{{ old("variants.$index.price") }}">
                                                    @error("variants.$index.price")
                                                        <div class="text-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM đã được tải thành công');
            // Chuyển dữ liệu từ Laravel vào biến JavaScript
            let oldVariants = @json(old('variants', [])); 
            let attributeIndex = oldVariants.length; // Số lượng variants sẽ làm index ban đầu
            let selectedSizes = oldVariants.map(variant => variant.size_id) || []; // Mảng lưu các size đã chọn

            console.log(selectedSizes);
            

            // Cập nhật lại danh sách các kích cỡ đã chọn để tránh trùng
            function updateSizeOptions() {
                const allSizeSelects = document.querySelectorAll('.size-select');
                console.log(allSizeSelects);

                allSizeSelects.forEach(select => {
                    const currentValue = select.value;
                    
                    // Tạo HTML cho các option với những giá trị đã chọn
                    let optionsHTML = '<option value="">--Chọn kích cỡ--</option>';
                    @foreach ($allSize as $size)
                        optionsHTML += `<option value="{{ $size->id }}" 
                            
                            ${currentValue  == {{ $size->id }} ? 'selected' : ''}
                            >
                            Size {{ $size->name }}
                        </option>`;
                    @endforeach
                    
                    // Đặt lại các lựa chọn cho mỗi select
                    select.innerHTML = optionsHTML;

                    // Giữ nguyên giá trị hiện tại
                    select.value = currentValue;
                    console.log(select);

                    
                });
            }

            updateSizeOptions();

            // Xử lý khi nhấn nút thêm thuộc tính
                document.getElementById('add-attribute').addEventListener('click', function () {
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
                                        <select id="inputStatus${attributeIndex}" name="variants[${attributeIndex}][size_id]" class="form-control size-select">
                                            <option value="">--Chọn kích cỡ--</option>
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
                                        <label for="weight${attributeIndex}">Trọng lượng</label>
                                        <input type="text" id="weight${attributeIndex}" class="form-control" name="variants[${attributeIndex}][weight]">
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

                    // Lấy phần tử chọn size trong nhóm thuộc tính vừa tạo
                    const sizeSelect = newAttributeGroup.querySelector('.size-select');

                    // Đặt giá trị mặc định nếu có
                    if (oldVariants[attributeIndex]) {
                        sizeSelect.value = oldVariants[attributeIndex]['size_id'];
                        selectedSizes.push(sizeSelect.value); // Lưu vào selectedSizes
                    }

                    // Xử lý khi chọn kích cỡ
                    sizeSelect.addEventListener('change', function () {
                        const previousValue = sizeSelect.dataset.previousValue || ''; // Lấy giá trị cũ
                        const selectedSize = sizeSelect.value;

                        // Nếu có giá trị cũ, loại bỏ khỏi mảng
                        if (previousValue) {
                            const index = selectedSizes.indexOf(previousValue);
                            if (index > -1) {
                                selectedSizes.splice(index, 1);
                            }
                        }

                        // Kiểm tra xem kích cỡ đã được chọn chưa
                        if (selectedSizes.includes(selectedSize)) {
                            alert("Kích cỡ này đã được chọn. Vui lòng chọn kích cỡ khác.");
                            sizeSelect.value = ''; // Hủy lựa chọn kích cỡ đã chọn
                            return; // Không cho phép chọn trùng
                        }

                        // Thêm giá trị mới vào mảng nếu không trống
                        if (selectedSize) {
                            selectedSizes.push(selectedSize);
                            console.log(selectedSizes);
                        }

                        // Lưu giá trị mới làm giá trị trước đó
                        sizeSelect.dataset.previousValue = selectedSize;

                        // Cập nhật danh sách kích cỡ khả dụng
                        updateSizeOptions();
                    });

                    // Gán sự kiện xóa cho nút trong thuộc tính vừa tạo
                    newAttributeGroup.querySelector('.remove-attribute').addEventListener('click', function () {
                        const previousValue = sizeSelect.value;
                        // Nếu có giá trị cũ, loại bỏ khỏi mảng
                        if (previousValue) {
                            const index = selectedSizes.indexOf(previousValue);
                            if (index > -1) {
                                selectedSizes.splice(index, 1);
                            }
                        }

                        // Xóa nhóm thuộc tính
                        attributesContainer.removeChild(newAttributeGroup);

                        // Cập nhật danh sách kích cỡ khả dụng
                        updateSizeOptions();
                    });

                    attributeIndex++; // Tăng chỉ số thuộc tính
                    updateSizeOptions(); // Cập nhật lại danh sách kích cỡ khi thêm thuộc tính
                });

                document.querySelectorAll('.remove-attribute').forEach(button =>{
                    button.addEventListener('click', function () {
                        // Tìm phần tử cha chứa cả nhóm thuộc tính
                        const attributeGroup = button.closest('.card');
                        if (attributeGroup) {
                            attributeGroup.remove(); // Xóa toàn bộ nhóm thuộc tính
                        }
                        
                    });
                });

                // Xử lý nhóm thuộc tính khi khởi tạo (giá trị từ old)
                document.querySelectorAll('.size-select').forEach(select => {
                    select.addEventListener('change', function () {
                        const previousValue = select.dataset.previousValue || '';
                        const selectedSize = select.value;

                        if (previousValue) {
                            const index = selectedSizes.indexOf(previousValue);
                            if (index > -1) selectedSizes.splice(index, 1);
                        }

                        if (selectedSizes.includes(selectedSize)) {
                            alert('Kích cỡ này đã được chọn, vui lòng chọn kích cỡ khác.');
                            select.value = '';
                            return;
                        }

                        if (selectedSize) selectedSizes.push(selectedSize);

                        select.dataset.previousValue = selectedSize;
                        updateSizeOptions();
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
