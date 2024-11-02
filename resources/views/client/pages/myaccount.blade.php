@extends('client.components.default')

@push('styles')
    
@endpush

@section('content')
    <!-- HEADING-BANNER START -->
    <div class="heading-banner-area overlay-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2>Tài Khoản Của Tôi</h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="index.html">Trang Chủ</a></li>
                                <li>Tài Khoản Của Tôi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- HEADING-BANNER END -->
    <div class="my-account-area  pt-80 pb-80">
        <div class="container">	
            <div class="my-account">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="accordion" id="accordion-1">
                            <div class="accordion-item mb-10">
                              <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personal-information">
                                  AMy Personal Information
                                </button>
                              </h2>
                              <div id="personal-information" class="accordion-collapse collapse show" data-bs-parent="#accordion-1">
                                <div class="accordion-body">
                                    <div class="billing-details shop-cart-table">
                                        <input type="text" placeholder="Your name here...">
                                        <input type="text" placeholder="Email address here...">
                                        <input type="text" placeholder="Phone here...">
                                        <input type="text" placeholder="Company neme here...">
                                        <select class="custom-select mb-15">
                                            <option>Contry</option>
                                            <option>Bangladesh</option>
                                            <option>United States</option>
                                            <option>united Kingdom</option>
                                            <option>Australia</option>
                                            <option>Canada</option>
                                        </select>
                                        <select class="custom-select mb-15">
                                            <option>State</option>
                                            <option>Dhaka</option>
                                            <option>New York</option>
                                            <option>London</option>
                                            <option>Melbourne</option>
                                            <option>Ottawa</option>
                                        </select>
                                        <select class="custom-select mb-15">
                                            <option>Town / City</option>
                                            <option>Dhaka</option>
                                            <option>New York</option>
                                            <option>London</option>
                                            <option>Melbourne</option>
                                            <option>Ottawa</option>
                                        </select>
                                        <textarea placeholder="Your address here..." class="custom-textarea"></textarea>
                                    </div>
                                </div>
                              </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="accordion-item mb-10">
                            <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order-details">
                                  Order history and details
                              </button>
                            </h2>
                            <div id="order-details" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordion-1">
                              <div class="accordion-body">
                                  <div class="our-order payment-details shop-cart-table">
                                      <table>
                                          <thead>
                                              <tr>
                                                  <th><strong>Product</strong></th>
                                                  <th class="text-right"><strong>Total</strong></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>Dummy Product Name  x 2</td>
                                                  <td class="text-right">$86.00</td>
                                              </tr>
                                              <tr>
                                                  <td>Dummy Product Name  x 1</td>
                                                  <td class="text-right">$69.00</td>
                                              </tr>
                                              <tr>
                                                  <td>Cart Subtotal</td>
                                                  <td class="text-right">$155.00</td>
                                              </tr>
                                              <tr>
                                                  <td>Shipping and Handing</td>
                                                  <td class="text-right">$15.00</td>
                                              </tr>
                                              <tr>
                                                  <td>Vat</td>
                                                  <td class="text-right">$00.00</td>
                                              </tr>
                                              <tr>
                                                  <td>Order Total</td>
                                                  <td class="text-right">$170.00</td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                            </div>
                          </div>							
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
