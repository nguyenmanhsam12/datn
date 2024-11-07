@extends('client.components.default')

@push('styles')
    <style>
        
    </style>
@endpush

@section('content')
<div class="heading-banner-area overlay-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-banner">
                    <div class="heading-banner-title">
                        <h2>Đơn Hàng Của Tôi</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="#">Trang Chủ</a></li>
                            <li>Đơn Hàng Của Tôi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="order-page container">
    <div class="order-page__sidebar">
        <div class="sidebar__menu">
            <h3>Danh Mục</h3>
            <ul>
                <li><a href="">Tất cả đơn hàng</a></li>
                <li><a href="">Đơn hàng đã đặt</a></li>
                <li><a href="">Đơn hàng đã hủy</a></li>
                <li><a href="">Đơn hàng đã hoàn thành</a></li>
            </ul>
        </div>
    </div>
    <div class="order-page__main">
        hihi
    </div>
</div>
  
@endsection

@push('script')
    <script>

    </script>
@endpush