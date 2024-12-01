@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bài viết đã xóa</h1>
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
           
        
            @if($deletedPosts->isEmpty())
                <p>Không có bài viết đã xóa.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Ngày xóa</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedPosts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($post->content,80) }}</td>

                                <td>{{ $post->deleted_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Phục hồi</button>
                                    </form>
                                    <form action="{{ route('admin.posts.forceDelete', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bài viết này?')">Xóa vĩnh viễn</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
         
            @endif
        </div>
@endsection

