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
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
                            <h3 class="card-title">Cập nhập sản phẩm</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.product.update',['id'=>$product->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="nhập tên sản phẩm"name="name"
                                        value="{{$product->name}}"
                                        >
                                    @error('name')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã sp</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="nhập mã"
                                        name="sku"
                                        value="{{$product->sku}}">
                                    @error('sku')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <textarea name="description" id="summernote" cols="10" rows="5" class="form-control">
                                        {{$product->description}}
                                    </textarea>

                                    @error('description')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">--Chọn danh mục--</option>
                                        @foreach ($allCategory as $cate)
                                            <option value="{{ $cate->id }}" {{$cate->id == $product->category_id ? 'selected' : ''}}>{{ $cate->name }}</option>
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
                                            <option value="{{ $brand->id }}" {{$brand->id == $product->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh chính</label>
                                    <input type="file"name="image" class="form-control">
                                    <img src="{{$product->image}}" alt="" width="100" height="100">
                                    @error('image')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh phụ</label>
                                    <input type="file" name="gallary[]" class="form-control" multiple>
                                    @foreach ($product->gallary as $gala)
                                        <img src="{{ asset($gala) }}" alt="" width="100" height="100">
                                    @endforeach
                                    @error('gallary')
                                        <div class="text-danger mt-3">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    $(function () {
         // Summernote
         $('#summernote').summernote()

     
     })
 </script>
@endpush


