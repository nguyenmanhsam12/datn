@extends('client.components.default')

@section('content')
    <div class="heading-banner-area overlay-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2>Wishlist</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                                <li>Wishlist</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pt-80 pb-80 product-style-2">
        <div class="container">
            <div class="shop-content">
                <div class="product-option mb-30">
                    <p class="mb-0">Bạn đang có {{ $wishlistProducts->count() }} sản phẩm yêu thích</p>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active show" id="grid-view" role="tabpanel">
                        <div class="row">
                            @forelse ($wishlistProducts as $item)
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <a href="{{ route('getDetailProduct', ['slug' => $item->product->slug]) }}">
                                            <div class="product-img pro-img">
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" />
                                                <div class="product-action clearfix spor" >
                                                    <a href="">
                                                        <form action="{{ route('wishlist.remove', $item->product->id) }}"
                                                            method="POST" class="remove-wishlist-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="remove-wishlist"
                                                                title="Remove from Wishlist"
                                                                data-id="{{ $item->product->id }}">
                                                                <i class="zmdi zmdi-favorite"></i>
                                                            </button>
                                                        </form>
                                                    </a>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                                        title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-info clearfix">
                                                <h4>{{ $item->product->name }}</h4>
                                                <span>{{ number_format(optional($item->product->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">Không có sản phẩm nào trong wishlist của bạn.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="shop-pagination text-center">
                    <div class="pagination-wrapper pagination">
                        {{ $wishlistProducts->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.remove-wishlist-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Lấy productId từ data-id của button
                    const productId = this.querySelector('button').getAttribute('data-id');

                    // Gửi yêu cầu AJAX để xóa sản phẩm
                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                _method: 'DELETE',
                                product_id: productId,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cập nhật lại phần sản phẩm wishlist mà không tải lại toàn bộ trang
                                const productAreaElement = document.querySelector(
                                    '.product-area');
                                productAreaElement.innerHTML = data.html;
                                location.reload()
                                alert(data.message);
                            } else {
                                alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Đã xảy ra lỗi khi xóa sản phẩm.');
                        });
                });
            });
        });
    </script>
@endpush
