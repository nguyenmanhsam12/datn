@extends('admin.layout.default')

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
                            <li class="breadcrumb-item active">Bài viết</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
<section class="content">
    <h1>{{ isset($post) ? 'Sửa' : 'Thêm' }} bài viết</h1>
    <form action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif
        
      <!-- Tiêu đề -->
<div class="form-group">
    <label for="title">Tiêu đề</label>
    <input type="text" name="title" class="form-control" value="{{ $post->title ?? old('title') }}" required>
</div>

<!-- Tiêu đề phụ -->
<div class="form-group">
    <label for="subtitle">Tiêu đề phụ</label>
    <input type="text" name="subtitle" class="form-control" value="{{ $post->subtitle ?? old('subtitle') }}">
</div>

<!-- Nội dung -->
<div class="form-group">
    <label for="content">Nội dung</label>
    <textarea name="content" class="form-control" rows="5" required>{{ $post->content ?? old('content') }}</textarea>
</div>

<!-- Nội dung phụ -->
<div class="form-group">
    <label for="secondary_content">Nội dung phụ</label>
    <textarea name="secondary_content" class="form-control" rows="5">{{ $post->secondary_content ?? old('secondary_content') }}</textarea>
</div>

<!-- Ảnh đại diện -->
<div class="form-group">
    <label for="thumbnail">Ảnh đại diện</label>
    <input type="file" name="thumbnail" class="form-control">
    @if(isset($post) && $post->thumbnail)
        <img src="{{ asset('thumbnail/' . $post->thumbnail) }}" alt="Thumbnail" width="100">
    @endif
</div>

<!-- Ảnh phụ -->
<div class="form-group">
    <label for="secondary_image">Ảnh phụ</label>
    <input type="file" name="secondary_image" class="form-control">
    @if(isset($post) && $post->secondary_image)
        <img src="{{ asset('thumbnail/' . $post->secondary_image) }}" alt="Secondary Thumbnail" width="100">
    @endif
</div>


        <!-- Submit -->
        <button type="submit" class="btn btn-success">{{ isset($post) ? 'Cập nhật' : 'Thêm' }}</button>
    </form>
</section>

@endsection
