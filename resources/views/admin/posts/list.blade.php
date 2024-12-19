@extends('admin.layout.default')

@section('content')
    <style>
        .content-column {
            max-width: 300px;



        }

        .custom-btn {
            padding: 0.2rem 0.5rem;
            /* Điều chỉnh kích thước */
            background-color: transparent;
            /* Không có nền */
            border: none;
            /* Không có viền */
            display: inline-flex;
            /* Dùng flex để căn giữa */
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            opacity: 1;
            /* Đảm bảo nút có độ mờ ban đầu */
            transition: opacity 0.3s ease;
            /* Hiệu ứng mờ dần */
            vertical-align: middle;
            /* Căn giữa theo chiều dọc */
            margin-top: 33px
        }

        .custom-btn:hover {
            opacity: 0.7;
            /* Khi hover sẽ mờ đi */
        }

        .custom-btn i {
            font-size: 1.5rem;
            /* Điều chỉnh kích thước icon */
            transition: transform 0.3s ease;
            /* Hiệu ứng cho icon */
        }

        .custom-btn:hover i {
            transform: scale(1.2);
            /* Tăng kích thước icon khi hover */
            color: red
        }

        /* Đảm bảo modal có chiều rộng 80% */
        .modal-dialog {
            max-height: 80%;
            /* Giới hạn chiều cao tối đa của modal */
            margin-top: 5%;
            /* Để modal không quá sát với phía trên */
        }

        /* Điều chỉnh nội dung modal */
        .modal-body {
            max-height: 400px;
            /* Giới hạn chiều cao của nội dung */
            overflow-y: auto;
            /* Nếu nội dung vượt quá chiều cao, thanh cuộn sẽ xuất hiện */
        }

        /* Cải thiện hiển thị ảnh và nội dung trong modal */
        .modal-body img {
            width: 100%;
            height: auto;
            margin-bottom: 15px;
        }

        .modal-header h5 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Cải thiện căn chỉnh nội dung */
        .modal-body p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .modal-body h4 {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh sách bài viết</h1>
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

            @can('create', App\Models\Post::class)
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>
            @endcan
            <a href="{{ route('admin.posts.listDelete') }}" class="btn btn-danger mb-3">Bài viết đã xóa</a>
            <table class="table table-bordered mt-4" id="list-post">
                <thead>
                    <tr>
                        <td></td>
                        <th>Ảnh đại diện</th>
                        <th>Tiêu đề</th>


                        <th>Nội dung</th>
                        {{-- <th>Ảnh phụ</th>
                <th>Tiêu đề phụ</th>
                <th>Nội dung phụ</th> --}}<th>Người đăng</th>

                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                @can('view', [App\Models\Post::class,$post->id])
                                    <button type="button" class="btn custom-btn" data-toggle="modal"
                                        data-target="#productModal{{ $post->id }}">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </button>
                                @endcan
                            </td>

                            <!-- CHi tiết -->
                           

                                <div class="modal fade" id="productModal{{ $post->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="productModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title post-title" id="productModalLabel{{ $post->id }}">
                                                    {{ $post->title }}</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Người đăng:</strong> {{ $post->author->name }}</p>
                                                <p><strong>Ngày đăng:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</p>

                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <img src="{{ asset($post->thumbnail) }}" alt="Thumbnail"
                                                            class="img-fluid" style="width: 200px; height: 300px;">
                                                    </div>
                                                    <div class="col-md-8">

                                                        <h5><strong>Nội dung:</strong></h5>
                                                        <p>{{ $post->content }}</p>
                                                    </div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        @if ($post->secondary_image)
                                                            <img src="{{ asset($post->secondary_image) }}"
                                                                alt="Secondary Image" class="img-fluid"
                                                                style="width: 200px; height: 300px;">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h5><strong>{{ $post->subtitle }}</strong></h5>
                                                        <p>{{ $post->secondary_content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            {{-- end chi tiết --}}
                            <td>
                                @if ($post->thumbnail)
                                    <img src="{{ asset($post->thumbnail) }}" alt="Thumbnail"
                                        style="width: 80px; height: auto;">
                                @else
                                    <span>Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($post->title, 50) }}</td>

                            <td class="content-column">{{ \Illuminate\Support\Str::limit($post->content, 100) }}</td>
                            {{-- <td> @if ($post->thumbnail)
                        <img src="{{ asset($post->secondary_image) }}" alt="Thumbnail" style="width: 100px; height: auto;">
                    @else
                        <span>Không có ảnh</span>
                    @endif</td> 
                    <td>{{ $post->subtitle }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->secondary_content,100) }}</td> --}}

                            {{-- <!-- Trạng thái -->
                    <td>{{ $post->is_published ? 'Đã xuất bản' : 'Nháp' }}</td> --}}<td>{{ $post->author->name }}</td>
                            <td>
                                @can('view', [App\Models\Post::class, $post->id])
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                @endcan
                                @can('delete', [App\Models\Post::class, $post->id])
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}

    </div>
@endsection

@push('script')
    <script>
        let table = new DataTable('#list-post');
    </script>
@endpush
