@extends('admin.layout.default')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Đánh giá</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Đánh giá</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container">
                <h1 class="mb-4">Quản lý đánh giá</h1>
            
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr id="review-row-{{ $review->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->user->name }}</td>
                                <td>{{ $review->product->name }}</td>
                                <td>
                                    <strong>Rating:</strong> {{ $review->rating }}<br>
                                    {{ $review->message }}
                                </td>
                                <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                         
                        @endforelse
                    </tbody>
                </table>
            
         
            </div>

        </section>
        <!-- /.content -->
    </div>
    
@endsection
