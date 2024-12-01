<!-- resources/views/client/pages/partials/product-list.blade.php -->
@push('styles')
<style>
    .product-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .product-action button,
    .product-action a {
        padding: 10px;
        transition: color 0.3s ease, transform 0.3s ease;
        /* Hiệu ứng chuyển màu và phóng to nhẹ */
    }

    .product-action i {
        font-size: 1.3rem;
        /* Tăng kích cỡ biểu tượng */
    }

    .product-action button:hover i,
    .product-action a:hover i {
        color: #e03550;
        transform: scale(1.2);
    }
</style>
@endpush
@foreach ($list_product as $pr)
<div class="col-lg-4 col-md-6 col-12">
    <div class="single-product">
        <div class="product-img">
            <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                <span class="pro-label new-label">new</span>
                <img src="{{ $pr->image }}" alt="{{ $pr->image }}" />
                <div class="product-action clearfix spor">
                    <form action="{{ route('wishlist.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id"
                            value="{{ $pr->id }}">
                        <button type="submit" class=" btn-link"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Wishlist">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </button>
                    </form>
                    <a href="#" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Quick View">
                        <i class="zmdi zmdi-zoom-in"></i>
                    </a>
                    <a href="#" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Compare">
                        <i class="zmdi zmdi-refresh"></i>
                    </a>

                </div>
            </a>
        </div>
        <div class="product-info clearfix">
            <h4 data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $pr->name }}">{{ $pr->name }}</h4>
            <span>{{ number_format(optional($pr->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
        </div>
        <div class="clearfix">
            <div class="pro-rating floatright">
                <a href="#"><i class="zmdi zmdi-star"></i></a>
                <a href="#"><i class="zmdi zmdi-star"></i></a>
                <a href="#"><i class="zmdi zmdi-star"></i></a>
                <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                <a href="#"><i class="zmdi zmdi-star-half"></i></a>
            </div>
        </div>
    </div>
</div>
@endforeach