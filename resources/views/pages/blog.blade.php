@extends('layouts.app')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Blog - Portfolio')
@section('description', 'Latest blog posts and insights')
@section('keywords', 'blog, articles, insights, web development, design')

@section('content')
<!-- ====== Header ======  -->
<section class="header-blog">
    <div class="v-middle">
        <div class="container">
            <div class="row">
                <div class="caption">
                    <h1>Blog</h1>
                    <span>Latest insights and articles</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Header ======  -->

<!-- ====== Featured Posts ======  -->
@if($featuredPosts->count() > 0)
<section class="featured-posts section-padding bg-gray">
    <div class="container">
        <div class="section-head">
            <h3>Featured Posts</h3>
        </div>
        <div class="row">
            @foreach($featuredPosts as $post)
            <div class="col-md-4">
                <article class="featured-post">
                    @if($post->featured_image)
                    <div class="post-img">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                    </div>
                    @endif
                    <div class="content">
                        <div class="post-meta">
                            <span class="date">{{ $post->published_at->format('M d, Y') }}</span>
                            @if($post->category)
                            <span class="category">
                                <a href="{{ route('blog', ['category' => $post->category->slug]) }}">{{
                                    $post->category->name }}</a>
                            </span>
                            @endif
                        </div>
                        <h4>
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                        <p>{{ Str::limit($post->excerpt, 100) }}</p>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ====== Blog Section ======  -->
<section class="blog section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if($posts->count() > 0)
                @foreach($posts as $post)
                <article class="post mb-50">
                    @if($post->featured_image)
                    <div class="post-img">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                    </div>
                    @endif
                    <div class="content">
                        <div class="post-meta">
                            <span class="date">{{ $post->published_at->format('M d, Y') }}</span>
                            @if($post->category)
                            <span class="category">
                                <a href="{{ route('blog', ['category' => $post->category->slug]) }}">{{
                                    $post->category->name }}</a>
                            </span>
                            @endif
                            <span class="author">by {{ $post->author->name }}</span>
                        </div>
                        <h2>
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p>{{ $post->excerpt }}</p>
                        @if($post->tags && count($post->tags) > 0)
                        <div class="tags">
                            @foreach($post->tags as $tag)
                            <span class="tag">#{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                        <a href="{{ route('blog.show', $post->slug) }}" class="more">Read More</a>
                    </div>
                </article>
                @endforeach

                <!-- Pagination -->
                <div class="pagination">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="no-posts">
                    <h3>No posts found</h3>
                    <p>There are no published blog posts at the moment. Please check back later!</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar">
                    <!-- Search -->
                    <div class="widget search-widget">
                        <h5>Search</h5>
                        <form method="GET" action="{{ route('blog') }}">
                            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Categories -->
                    @if($categories->count() > 0)
                    <div class="widget categories-widget">
                        <h5>Categories</h5>
                        <ul>
                            <li><a href="{{ route('blog') }}" class="{{ !request('category') ? 'active' : '' }}">All
                                    Posts</a></li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog', ['category' => $category->slug]) }}"
                                    class="{{ request('category') === $category->slug ? 'active' : '' }}">
                                    {{ $category->name }}
                                    <span>({{ $category->blogPosts()->where('is_published', true)->count() }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Recent Posts -->
                    @if($posts->count() > 0)
                    <div class="widget recent-posts-widget">
                        <h5>Recent Posts</h5>
                        @foreach($posts->take(3) as $post)
                        <div class="recent-post">
                            @if($post->featured_image)
                            <div class="post-img">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                            </div>
                            @endif
                            <div class="post-content">
                                <h6><a href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 40)
                                        }}</a></h6>
                                <span class="date">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Blog Section ======  -->

@push('styles')
<style>
    .featured-post {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
    }

    .featured-post:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .featured-post .post-img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .featured-post .content {
        padding: 20px;
    }

    .featured-post h4 {
        margin: 10px 0;
        font-size: 16px;
    }

    .featured-post h4 a {
        color: #333;
        text-decoration: none;
    }

    .featured-post h4 a:hover {
        color: #007bff;
    }

    .post-meta {
        margin-bottom: 15px;
        font-size: 12px;
        color: #666;
    }

    .post-meta span {
        margin-right: 15px;
    }

    .post-meta .category a {
        color: #007bff;
        text-decoration: none;
    }

    .tags {
        margin: 15px 0;
    }

    .tag {
        display: inline-block;
        background: #f8f9fa;
        color: #666;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 8px;
        margin-bottom: 4px;
    }

    .categories-widget ul li a.active {
        color: #007bff;
        font-weight: 600;
    }

    .no-posts {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .header-blog {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url('{{ asset(' template/images/bg.jpg') }}');
        background-size: cover;
        background-position: center;
        min-height: 300px;
        display: flex;
        align-items: center;
        color: white;
        text-align: center;
    }

    .header-blog h1 {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .header-blog span {
        font-size: 18px;
        opacity: 0.9;
    }
</style>
@endpush
@endsection