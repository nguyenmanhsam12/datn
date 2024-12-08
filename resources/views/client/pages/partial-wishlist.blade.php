@push('styles')
    <style>

    </style>
@endpush
@if ($wishlists->count() > 0)
    <p>Bạn có {{ $wishlists->count() }} sản phẩm yêu thích</p>
    <div class="tab-content">
        <div class="tab-pane active show" id="grid-view" role="tabpanel">
            <div class="row" id="product-list">
                @foreach ($wishlists as $wishlist)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-product ">
                            <div class="product-img">
                                <a href="{{ route('getDetailProduct', ['slug' => $wishlist->product->slug]) }}">
                                    <img src="{{ $wishlist->product->image }}" alt="{{ $wishlist->product->name }}" />
                                    <div class="product-action clearfix spor">
                                        <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-remove-wishlist"
                                                data-wishlist-id="{{ $wishlist->id }}"
                                                data-url="{{ route('wishlist.remove', $wishlist->id) }}">
                                                <i class="zmdi zmdi-favorite-outline"></i>
                                            </button>
                                        </form>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal"
                                            title="Quick View">
                                            <i class="zmdi zmdi-zoom-in"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Compare">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </div>
                                </a>
                            </div>
                            <div class="product-info clearfix">
                                <h4>{{ $wishlist->product->name }}</h4>
                                <span>{{ number_format(optional($wishlist->product->mainVariant)->price, 0, ',', '.') . ' VNĐ' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="shop-pagination text-center">
                <div class="pagination-wrapper pagination">
                    {{ $wishlists->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@else
    <p>Không có sản phẩm trong danh sách yêu thích.</p>
@endif
