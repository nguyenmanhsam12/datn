@extends('client.components.default')

@section('content')
<div class="heading-banner-area overlay-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-banner">
                    <div class="heading-banner-title">
                        <h2>Liên Hệ</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Liên Hệ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADING-BANNER END -->
<!-- contact-us-AREA START -->
<div class="contact-us-area  pt-80 pb-80">
    <div class="container">	
        <div class="contact-us customer-login bg-white">
            <div class="row">
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="contact-details">
                        <h4 class="title-1 title-border text-uppercase mb-30">Chi Tiết Liên Hệ</h4>
                        <ul>
                            <li>
                                <i class="zmdi zmdi-pin"></i>
                                <span>19C, Hoàng Diệu, Điện Biên</span>
                                <span>Ba Đình, Hà Nội</span>
                            </li>
                            <li>
                                <i class="zmdi zmdi-phone"></i>
                                <span>+880 1234 123456</span>
                                <span>+880 1234 123456</span>
                            </li>
                            <li>
                                <i class="zmdi zmdi-email"></i>
                                <span>info@dwog.net</span>
                                <span>lewlew@gmail.com</span>
                            </li>
                        </ul>
                    </div>
                    <div class="send-message mt-60">
                        <form action="">
                            <h4 class="title-1 title-border text-uppercase mb-30">Phản Hồi</h4>
                            <input type="text" name="name" placeholder="Your name here..." />
                            <input type="text" name="email" placeholder="Your email here..." />
                            <textarea class="custom-textarea" name="message" placeholder="Your comment here..."></textarea>
                            <button class="button-one submit-button mt-20" data-text="Gửi Phản Hồi" type="submit">Gửi Phản Hồi</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-12 mt-xs-30">
                    <div class="map-area">
                        <iframe class="map-size" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9869567806822!2d105.83673777471455!3d21.033207887626872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aba2eaa84cc5%3A0xadc8e27077265f7e!2zMTlDIEhvw6BuZyBEaeG7h3UsIMSQaeG7h24gQmnDqm4sIEJhIMSQw6xuaCwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2sbd!4v1730881682070!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection