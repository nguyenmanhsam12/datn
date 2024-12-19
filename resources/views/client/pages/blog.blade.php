@extends('client.components.default')

@section('content')
<style>

        .blog-photo img {
            width: 100%;
            height: 200px;
            object-fit: cover; /* Đảm bảo ảnh đồng nhất kích thước */
        }

        .post-title {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

</style>
 <!-- HEADING-BANNER START -->
 <div class="heading-banner-area overlay-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-banner">
                    <div class="heading-banner-title">
                        <h2>Tin Tức</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Tin tức</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADING-BANNER END -->
<!-- BLGO-AREA START -->
<div class="blog-area blog-2  pt-80 pb-80">
    <div class="container">	
        <div class="blog">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-option d-flex flex-column-reverse flex-md-row justify-content-between align-items-center mb-30">
                        <div class="left d-flex">
                        
                        </div>
                        <div class="right">
                            <!-- Size end -->								
                            <div class="showing text-end">
                                <p class="mb-0 hidden-xs">Showing 01-09 of 17 Results</p>
                            </div>
                        </div>						
                    </div>						
                </div>							
            </div>
            @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
            <div class="row">
                @if($posts->isEmpty())
                <p>Không có bài viết nào.</p>
            @else
                @foreach ($posts as $post)
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="{{ route('blog.show', $post->id) }}" class="blog-photo">
                            <img src="{{ asset($post->thumbnail) }}" alt="Hình ảnh bài viết" style="max-width: 350px;"></a>
                            {{-- <div class="like-share text-center fix">
                                <a href="javascript:void(0);" class="like-button" data-post-id="{{ $post->id }}">
                                    <i class="zmdi zmdi-favorite"></i>
                                    <span>Like</span>
                                </a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span> Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>Share</span></a>
                            </div> --}}
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="{{ route('blog.show', $post->id) }}" tabindex="0">{{ \Illuminate\Support\Str::limit($post->title,50) }}</a></h4>
                                   
                                </div>
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit($post->content, 200) }}</p>
                            <a href="{{ route('blog.show', $post->id) }}" class="button-2 text-dark-red">Xem thêm...</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif


                <!-- Single-blog end -->







{{-- 
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/5.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Boyfriend Jeans Bright</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/6.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Matchbox' Fit Jeans</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/7.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Mixed Media Top</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/8.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">New Fray Day' Polo</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/9.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Dot Men’s Pants</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/4.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Cotton Jersey Polo</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/8.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Three-Piece Check</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end -->
                <!-- Single-blog start -->
                <div class="col-lg-4 col-md-6 col-12 d-none d-lg-block">
                    <div class="single-blog mb-30">
                        <div class="blog-photo">
                            <a href="#"><img src="img/blog/6.webp" alt="" /></a>
                            <div class="like-share text-center fix">
                                <a href="#"><i class="zmdi zmdi-favorite"></i><span>89 Like</span></a>
                                <a href="#"><i class="zmdi zmdi-comments"></i><span>59 Comments</span></a>
                                <a href="#"><i class="zmdi zmdi-share"></i><span>29 Share</span></a>
                            </div>
                        </div>
                        <div class="blog-info"> 
                            <div class="post-meta fix">
                                <div class="post-year floatleft">
                                    <h4 class="post-title"><a href="#" tabindex="0">Silk Blend Sweater</a></h4>
                                </div>
                            </div>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered If you are going to use a passage  Lorem Ipsum, you alteration in some form.</p>
                            <a href="#" class="button-2 text-dark-red">Read more...</a>
                        </div>
                    </div>
                </div>
                <!-- Single-blog end --> --}}
            </div>	
            <div class="row">
                <div class="col-12">
                    <!-- Pagination start -->
                    <div class="shop-pagination text-center">
                        <div class="pagination">
                            <ul>
                                <li><a href="#"><i class="zmdi zmdi-long-arrow-left"></i></a></li>
                                <li><a href="#">01</a></li>
                                <li class="active"><a href="#">02</a></li>
                                <li><a href="#">03</a></li>
                                <li><a href="#">04</a></li>
                                <li><a href="#">05</a></li>
                                <li><a href="#"><i class="zmdi zmdi-long-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Pagination end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLGO-AREA END -->	
			

@endsection


