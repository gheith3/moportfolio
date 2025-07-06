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
<section id="home" class="min-header" data-scroll-index="0">
    <div class="v-middle mt-30">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h5>Blog Posts</h5>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('blog') }}">Blog</a>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>
<!-- ====== End Header ======  -->

<!--====== Blog ======-->
<section class="blogs section-padding">
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="posts">

                    @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <div class="post">
                        @if($post->featured_image)
                        <div class="post-img">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        @else
                        <div class="post-img">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ asset('template/img/blog/1.jpg') }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        @endif

                        <div class="content text-center">
                            <div class="post-meta">
                                <div class="post-title">
                                    <h5>
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h5>
                                </div>
                                <ul class="meta">
                                    <li>
                                        <a href="#0">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            {{ $post->author->name }}
                                        </a>
                                    </li>
                                    @if($post->category)
                                    <li>
                                        <a href="{{ route('blog', ['category' => $post->category->slug]) }}">
                                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                                            {{ $post->category->name }}
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="#0">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            {{ $post->published_at->format('d M Y') }}
                                        </a>
                                    </li>
                                    @if($post->tags && count($post->tags) > 0)
                                    <li>
                                        <a href="#0">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            {{ implode(',', $post->tags) }}
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="#0">
                                            <i class="fa fa-comments" aria-hidden="true"></i>
                                            0 Comments
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="post-cont">
                                <p>{{ Str::limit($post->excerpt ?: strip_tags($post->content), 150) }}</p>
                            </div>

                            <a href="{{ route('blog.show', $post->slug) }}" class="butn">Read More</a>

                        </div>
                    </div>
                    @endforeach

                    <div class="pagination">
                        {{ $posts->links('pagination::simple-bootstrap-4') }}
                    </div>
                    @else
                    <div class="post">
                        <div class="content text-center">
                            <h3>No posts found</h3>
                            <p>There are no published blog posts at the moment. Please check back later!</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="side-bar">
                    <div class="widget search">
                        <form method="GET" action="{{ route('blog') }}">
                            <input type="search" name="search" placeholder="Type here ..."
                                value="{{ request('search') }}">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>

                    @if($posts->count() > 0)
                    <div class="widget">
                        <div class="widget-title">
                            <h6>Recent Posts</h6>
                        </div>
                        <ul>
                            @foreach($posts->take(5) as $post)
                            <li><a href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="widget">
                        <div class="widget-title">
                            <h6>Recent Comments</h6>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-title">
                            <h6>Archives</h6>
                        </div>
                        <ul>
                            @php
                            $archives = $posts->groupBy(function($date) {
                            return $date->published_at->format('F Y');
                            });
                            @endphp
                            @foreach($archives->take(6) as $month => $monthPosts)
                            <li><a href="#0">{{ $month }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    @if($categories->count() > 0)
                    <div class="widget">
                        <div class="widget-title">
                            <h6>Categories</h6>
                        </div>
                        <ul>
                            @foreach($categories as $category)
                            <li><a href="{{ route('blog', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif



                </div>
            </div>

        </div>
    </div>
</section>
<!--====== End Blog ======-->
@endsection