<div class="product-area pt-80 pb-80 product-style-2">
    <div class="container">
        <div class="shop-content">
            <div class="product-option mb-30">
                <p class="mb-0">Hiển thị {{ $wishlistProducts->count() }} sản phẩm trong wishlist</p>
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
                                            <div class="product-action clearfix">
                                                <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" class="remove-wishlist-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="remove-wishlist" title="Remove from Wishlist" data-id="{{ $item->product->id }}">
                                                        <i class="zmdi zmdi-favorite"></i>
                                                    </button>
                                                </form>
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
