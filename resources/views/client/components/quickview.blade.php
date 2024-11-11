<div id="quickview-wrapper">
    <!-- Modal -->
    <div class="modal fade" id="productModal{{ $pr->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div class="modal-product">
                         <div class="product-images">
                             <div class="main-image images">
                                 <img alt="#" src="img/product/quickview-photo.webp"/>
                             </div>
                         </div><!-- .product-images -->

                         <div class="product-info">
                             <h1>Aenean eu tristique</h1>
                             <div class="price-box-3">
                                 <hr />
                                 <div class="s-price-box">
                                     <span class="new-price">$160.00</span>
                                     <span class="old-price">$190.00</span>
                                 </div>
                                 <hr />
                             </div>
                             <a href="shop.html" class="see-all">See all features</a>
                             <div class="quick-add-to-cart">
                                 <form method="post" class="cart">
                                     <div class="numbers-row">
                                         <input type="number" min="1" id="french-hens" value="3">
                                     </div>
                                     <button class="single_add_to_cart_button" type="submit">Add to cart</button>
                                 </form>
                             </div>
                             <div class="quick-desc">
                                 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.
                             </div>
                             <div class="social-sharing">
                                 <div class="widget widget_socialsharing_widget">
                                     <h3 class="widget-title-modal">Share this product</h3>
                                     <ul class="social-icons">
                                         <li><a target="_blank" title="Google +" href="#" class="gplus social-icon"><i class="zmdi zmdi-google-plus"></i></a></li>
                                         <li><a target="_blank" title="Twitter" href="#" class="twitter social-icon"><i class="zmdi zmdi-twitter"></i></a></li>
                                         <li><a target="_blank" title="Facebook" href="#" class="facebook social-icon"><i class="zmdi zmdi-facebook"></i></a></li>
                                         <li><a target="_blank" title="LinkedIn" href="#" class="linkedin social-icon"><i class="zmdi zmdi-linkedin"></i></a></li>
                                     </ul>
                                 </div>
                             </div>
                         </div><!-- .product-info -->
                     </div><!-- .modal-product -->
                 </div><!-- .modal-body -->
             </div><!-- .modal-content -->
         </div><!-- .modal-dialog -->
    </div>
    <!-- END Modal -->
</div>