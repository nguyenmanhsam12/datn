@extends('client.components.default')

@section('content')
<style>


/* Bài viết chính */
.blog-content {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
}

.blog-header h4 {
    font-size: 24px;
    font-weight: bold;
    color: black;
    margin-bottom: 10px;
}

.blog-header p {
    font-size: 14px;
    color: #666;
}

/* Sidebar */
.sidebar h4 {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    color: black;
}

.recent-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
a{
    color: black
}

.recent-post-item {
    display: flex;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.recent-post-item:last-child {
    border-bottom: none;
}

.recent-post-image img {
    border-radius: 5px;
    transition: transform 0.3s ease;
}

.recent-post-image img:hover {
    transform: scale(1.1);
}

.recent-post-content h5 {
    font-size: 16px;
    margin: 0 0 5px;
    color: black;
}

.recent-post-content h5:hover {
    color: rgb(186, 105, 105);
}

.recent-post-content p {
    font-size: 14px;
    color: black;
}
h6:hover{
    color: rgb(117, 112, 230)
}

.recent-post-content {
    display: flex;
    flex-direction: column;
    justify-content: center; /* Đảm bảo chữ nằm giữa theo chiều dọc */
}




</style>
<!-- HEADING-BANNER START -->
<div class="heading-banner-area overlay-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-banner">
                    <div class="heading-banner-title">
                        <h2>Tin tức</h2>
                    </div>
                    <div class="breadcumbs pb-15">
                        <ul>
                            <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                            <li><a href="">Tin tức</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HEADING-BANNER END -->

<!-- BLOG-AREA START -->
<div class="blog-area blog-2 pt-80 pb-80">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-8">
                <div class="single-blog-post">
                    <!-- Title, Author & Date -->
                    <div class="blog-header mb-4">
                        <h1>{{ $post->title }}</h1>
                        <p class="author-date">
                            <strong>Tác giả:</strong> {{ $post->author->name ?? 'N/A' }} | 
                            <strong>Ngày đăng:</strong> {{ $post->created_at->format('d-m-Y') }}
                        </p>
                    </div>

                    <!-- Thumbnail -->
                    <div class="blog-image mb-4">
                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid rounded">
                    </div>

                    <!-- Content -->
                    <div class="blog-content mb-4">
                        <p>{{ $post->content }}</p>
                    </div>

                    <h4>{{ $post->subtitle }}</h4>

                    <!-- Secondary Image -->
                    @if($post->secondary_image)
                        <div class="secondary-image mb-4">
                            <img src="{{ asset($post->secondary_image) }}" alt="Secondary Image" class="img-fluid rounded">
                        </div>
                    @endif



                                        <!-- Secondary Content -->
                                        @if($post->secondary_content)
                                        <div class="blog-content mb-4">
                                            <h5></h5>
                                            <p>{{ $post->secondary_content }}</p>
                                        </div>
                                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Recent Posts -->
                    <h4 class="mb-4">Bài viết mới</h4>
                    <ul class="recent-posts-list">
                        @foreach ($recentPosts as $recentPost)
                        <li class="d-flex align-items-center mb-3" style="min-height: 100px;">
                            <!-- Image -->
                            <div class="recent-post-image me-3" style="flex-shrink: 0;">
                                <a href="{{ route('blog.show', $recentPost->id) }}">
                                    <img src="{{ asset($recentPost->thumbnail) }}" 
                                         alt="{{ $recentPost->title }}" 
                                         class="img-fluid rounded" 
                                         style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                                </a>
                            </div>
                    
                            <!-- Content -->
                            <div class="recent-post-content" style="flex: 1;">
                                <a href="{{ route('blog.show', $recentPost->id) }}">
                                    <h5 class="mb-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                         {{ Str::limit(strip_tags($recentPost->title), 30, '...') }}
                                    </h5>
                                </a>
                                <p class="text-muted mb-0" style="font-size: 14px;">
                                    {{ Str::limit(strip_tags($recentPost->content), 100, '...') }}
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                  

                    <!-- Related Posts -->
                    <div class="related-posts mt-5">
                        <h4>Bài viết liên quan</h4>
                        <ul class="list-unstyled">
                            @foreach ($recentPosts as $relatedPost)
                                <li class="mb-2">
                                    <a href="{{ route('blog.show', $relatedPost->id) }}" class="text-decoration-none">
                                        <h6 class="text">{{ $relatedPost->title }}</h6>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BLOG-AREA END -->

<!-- BLOG-AREA END -->  

@endsection
