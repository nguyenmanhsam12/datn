<!-- resources/views/client/pages/partials/product-list.blade.php -->
@foreach ($list_product as $pr)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="single-product">
            <div class="product-img">
                <a href="{{ route('getDetailProduct', ['slug' => $pr->slug]) }}">
                    <span class="pro-label new-label">new</span>
                    <img src="{{ $pr->image }}" alt="{{ $pr->name }}" />
                    <div class="product-action clearfix spor">
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                    </div>
                </a>
            </div>
            <div class="product-info clearfix">
                <h4>{{ $pr->name }}</h4>
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
