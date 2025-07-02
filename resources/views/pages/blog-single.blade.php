@extends('layouts.app')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', $post->meta_title ?: $post->title . ' - Blog')
@section('description', $post->meta_description ?: Str::limit($post->excerpt, 160))
@section('keywords', $post->tags ? implode(', ', $post->tags) : 'blog, article')

@section('content')
<!-- ====== Header ======  -->
<section class="header-blog">
    <div class="v-middle">
        <div class="container">
            <div class="row">
                <div class="caption">
                    <h1>{{ $post->title }}</h1>
                    <div class="post-meta">
                        <span class="date">{{ $post->published_at->format('M d, Y') }}</span>
                        @if($post->category)
                        <span class="category">in {{ $post->category->name }}</span>
                        @endif
                        <span class="author">by {{ $post->author->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Header ======  -->

<!-- ====== Blog Post ======  -->
<section class="blog-single section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post-single">
                    @if($post->featured_image)
                    <div class="post-img">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                            class="img-responsive">
                    </div>
                    @endif

                    <div class="content">
                        <div class="post-meta-details">
                            <div class="meta-info">
                                <span class="date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $post->published_at->format('F d, Y') }}
                                </span>
                                @if($post->category)
                                <span class="category">
                                    <i class="fas fa-folder"></i>
                                    <a href="{{ route('blog', ['category' => $post->category->slug]) }}">{{
                                        $post->category->name }}</a>
                                </span>
                                @endif
                                <span class="author">
                                    <i class="fas fa-user"></i>
                                    {{ $post->author->name }}
                                </span>
                            </div>
                        </div>

                        @if($post->excerpt)
                        <div class="excerpt">
                            <p class="lead">{{ $post->excerpt }}</p>
                        </div>
                        @endif

                        <div class="post-content">
                            {!! $post->content !!}
                        </div>

                        @if($post->tags && count($post->tags) > 0)
                        <div class="post-tags">
                            <h5>Tags:</h5>
                            <div class="tags">
                                @foreach($post->tags as $tag)
                                <span class="tag">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="post-navigation">
                            <div class="nav-links">
                                <a href="{{ route('blog') }}" class="back-to-blog">
                                    <i class="fas fa-arrow-left"></i> Back to Blog
                                </a>

                                <div class="share-buttons">
                                    <span>Share:</span>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                                        target="_blank" class="social-share twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                        target="_blank" class="social-share facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                        target="_blank" class="social-share linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar">
                    <!-- Author Info -->
                    <div class="widget author-widget">
                        <h5>About the Author</h5>
                        <div class="author-info">
                            <h6>{{ $post->author->name }}</h6>
                            @if($post->author->profile && $post->author->profile->bio)
                            <p>{{ $post->author->profile->bio }}</p>
                            @else
                            <p>{{ $post->author->name }} is a content creator and developer sharing insights about
                                technology and web development.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedPosts->count() > 0)
                    <div class="widget related-posts-widget">
                        <h5>Related Posts</h5>
                        @foreach($relatedPosts as $related)
                        <div class="related-post">
                            @if($related->featured_image)
                            <div class="post-img">
                                <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}">
                            </div>
                            @endif
                            <div class="post-content">
                                <h6><a href="{{ route('blog.show', $related->slug) }}">{{ Str::limit($related->title,
                                        50) }}</a></h6>
                                <span class="date">{{ $related->published_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Back to Blog -->
                    <div class="widget">
                        <a href="{{ route('blog') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-arrow-left"></i> View All Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Blog Post ======  -->
@endsection

@push('styles')
<style>
    .header-blog {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
        url('{{ asset(' template/images/bg.jpg') }}');
        background-size: cover;
        background-position: center;
        min-height: 400px;
        display: flex;
        align-items: center;
        color: white;
        text-align: center;
    }

    .header-blog h1 {
        font-size: 42px;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .header-blog .post-meta {
        font-size: 16px;
        opacity: 0.9;
    }

    .header-blog .post-meta span {
        margin: 0 10px;
    }

    .post-single {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .post-single .post-img img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .post-single .content {
        padding: 40px;
    }

    .post-meta-details {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .meta-info span {
        display: inline-block;
        margin-right: 20px;
        color: #666;
        font-size: 14px;
    }

    .meta-info i {
        margin-right: 5px;
        color: #007bff;
    }

    .meta-info .category a {
        color: #666;
        text-decoration: none;
    }

    .meta-info .category a:hover {
        color: #007bff;
    }

    .excerpt {
        margin-bottom: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        border-radius: 4px;
    }

    .excerpt .lead {
        font-size: 18px;
        font-weight: 300;
        line-height: 1.6;
        margin: 0;
        color: #555;
    }

    .post-content {
        line-height: 1.8;
        font-size: 16px;
        color: #333;
    }

    .post-content h1,
    .post-content h2,
    .post-content h3,
    .post-content h4,
    .post-content h5,
    .post-content h6 {
        margin-top: 30px;
        margin-bottom: 15px;
        color: #333;
    }

    .post-content p {
        margin-bottom: 20px;
    }

    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin: 20px 0;
    }

    .post-content blockquote {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        margin: 20px 0;
        padding: 20px;
        font-style: italic;
    }

    .post-tags {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .post-tags h5 {
        margin-bottom: 15px;
        color: #333;
    }

    .tags {
        margin-bottom: 20px;
    }

    .tag {
        display: inline-block;
        background: #f8f9fa;
        color: #666;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin-right: 8px;
        margin-bottom: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tag:hover {
        background: #007bff;
        color: white;
    }

    .post-navigation {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }

    .nav-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .back-to-blog {
        color: #666;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .back-to-blog:hover {
        color: #007bff;
    }

    .share-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .share-buttons span {
        color: #666;
        margin-right: 10px;
    }

    .social-share {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .social-share:hover {
        transform: translateY(-2px);
    }

    .social-share.twitter {
        background: #1da1f2;
    }

    .social-share.facebook {
        background: #4267b2;
    }

    .social-share.linkedin {
        background: #0077b5;
    }

    .author-widget {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .author-info h6 {
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .author-info p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }

    .related-post {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .related-post:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .related-post .post-img {
        width: 80px;
        height: 60px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .related-post .post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .related-post .post-content h6 {
        margin: 0 0 5px 0;
        font-size: 14px;
        line-height: 1.4;
    }

    .related-post .post-content h6 a {
        color: #333;
        text-decoration: none;
    }

    .related-post .post-content h6 a:hover {
        color: #007bff;
    }

    .related-post .post-content .date {
        font-size: 12px;
        color: #666;
    }

    @media (max-width: 768px) {
        .header-blog h1 {
            font-size: 32px;
        }

        .post-single .content {
            padding: 20px;
        }

        .nav-links {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .share-buttons {
            justify-content: center;
        }
    }
</style>
@endpush