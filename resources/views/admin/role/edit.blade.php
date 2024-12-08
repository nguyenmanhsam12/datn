@extends('admin.layout.default')


@push('styles')
    <style>
        #permission{
            background-color:#28a745;
        }
        input[type = 'checkbox']{
            transform: scale(1.2);
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

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vai trò</li>
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
                            <h3 class="card-title">Sửa vai trò </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.role.update',['id'=>$role->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên vai trò</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập vai trò"name="name"value="{{ $role->name }}">
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="display_name">Mô tả vai trò</label>
                                    <input type="text" class="form-control" id="display_name" name="display_name"
                                    value="{{ $role->display_name }}"
                                    >
                                    @error('display_name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>
                                            <input type="checkbox" value="" class="checkall">
                                        </label>
                                        CheckAll
                                    </div>
                                    @foreach($permission as $key => $permiss)
                                        <div class="card border-primary mb-3 col-md-12">
                                                <div class="card-header"id="permission">
                                                    <label>
                                                        <input type="checkbox" value="" class="checkbox-wrapper"
                                                        >
                                                    </label>
                                                    Module {{ $permiss->name }}
                                                </div>
                                            
                                            <div class="row">
                                                @foreach ($permiss->permissionChildrent as $item)
                                                    <div class="card-body text-primary col-md-3">
                                                        <h5 class="card-title">
                                                            <label>
                                                                <input type="checkbox" value="{{ $item->id }}"
                                                                name="permission_id[]" class="checkbox-childrent"
                                                                {{ $permissionChecked->contains('id',$item->id) ? 'checked' : '' }}
                                                                >
                                                            </label>
                                                            {{ $item->name }}
                                                        </h5>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('permission_id')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập nhập</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection


@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lắng nghe sự kiện click vào các checkbox có class "checkbox-wrapper"
        const moduleCheckboxes = document.querySelectorAll('.checkbox-wrapper');
        const checkAll = document.querySelector('.checkall'); // Checkbox "CheckAll"
        const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        const childCheckboxes = document.querySelectorAll('.checkbox-childrent'); // Tất cả checkbox con

       
          // Kiểm tra lại trạng thái của checkbox "CheckAll" khi có thay đổi ở bất kỳ checkbox nào
        function checkCheckAll() {
            const allSelected = Array.from(childCheckboxes).every(checkbox => checkbox.checked);
            checkAll.checked = allSelected; // Nếu tất cả checkbox đều được chọn thì đánh dấu "CheckAll"
        }

        // Cập nhật trạng thái checkbox cha khi trang được tải lại
        moduleCheckboxes.forEach(moduleCheckbox => {
            const parent = moduleCheckbox.closest('.card');
            const childCheckboxes = parent.querySelectorAll('.checkbox-childrent');
            
            const allChecked = Array.from(childCheckboxes).every(checkbox => checkbox.checked);
            if (allChecked) {
                moduleCheckbox.checked = true; // Đánh dấu checkbox cha là được chọn nếu tất cả checkbox con đều được chọn
            }
        });

        // Kiểm tra trạng thái của checkbox "CheckAll" khi vào trang
        checkCheckAll();


        checkAll.addEventListener('change', function () {
                    allCheckboxes.forEach(checkbox => {
                        checkbox.checked = checkAll.checked;
                    });
        });

        moduleCheckboxes.forEach(moduleCheckbox => {
            moduleCheckbox.addEventListener('change', function () {
                const parent = moduleCheckbox.closest('.card');
                const childCheckboxes = parent.querySelectorAll('.checkbox-childrent');
                childCheckboxes.forEach(childCheckbox => {
                    childCheckbox.checked = moduleCheckbox.checked;
                });
            });
        });

        // Lắng nghe sự kiện thay đổi trạng thái của các checkbox con
        childCheckboxes.forEach(childCheckbox => {
            childCheckbox.addEventListener('change', function () {
                const parent = childCheckbox.closest('.card');
                const parentModuleCheckbox = parent.querySelector('.checkbox-wrapper');

                // Kiểm tra nếu tất cả checkbox con của quyền cha không được chọn thì bỏ tích checkbox cha
                const allChecked = Array.from(parent.querySelectorAll('.checkbox-childrent')).every(checkbox => checkbox.checked);
                parentModuleCheckbox.checked = allChecked; // Bỏ tích checkbox cha nếu không còn checkbox con nào được chọn
                checkAll.checked = allChecked;
                

            });
        });

        // Kiểm tra lại trạng thái của checkbox "CheckAll" khi có thay đổi ở bất kỳ checkbox con nào
        allCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                // Kiểm tra nếu tất cả checkbox con đã được chọn thì "CheckAll" cũng sẽ được chọn
                const allSelected = Array.from(allCheckboxes).every(checkbox => checkbox.checked);
                checkAll.checked = allSelected; // Nếu tất cả checkbox đều được chọn thì đánh dấu "CheckAll"
            });
        });

        
    });
</script>
@endpush

