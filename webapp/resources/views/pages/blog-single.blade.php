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
<section id="home" class="min-header" data-scroll-index="0">
    <div class="v-middle mt-30">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h5>{{ $post->title }}</h5>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('blog') }}">Blog</a>
                    <a href="#0">Post Details</a>
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

                    <div class="post mb-80">
                        @if($post->featured_image)
                        <div class="post-img">
                            <a href="#0">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        @else
                        <div class="post-img">
                            <a href="#0">
                                <img src="{{ asset('template/img/blog/1.jpg') }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        @endif

                        <div class="content text-center">
                            <div class="post-meta">
                                <div class="post-title">
                                    <h5>
                                        <a href="#0">{{ $post->title }}</a>
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
                                        <a href="#0">
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
                                @if($post->excerpt)
                                <p class="spical">{{ $post->excerpt }}</p>
                                @endif

                                <div class="post-content-body">
                                    {!! $post->content !!}
                                </div>
                            </div>

                            <div class="share-post">
                                <span>Share Post</span>
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    </li>
                                    <li><a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#0"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                    <li><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                            target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>


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

                    @if($relatedPosts->count() > 0)
                    <div class="widget">
                        <div class="widget-title">
                            <h6>Recent Posts</h6>
                        </div>
                        <ul>
                            @foreach($relatedPosts as $related)
                            <li><a href="{{ route('blog.show', $related->slug) }}">{{ Str::limit($related->title, 50)
                                    }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- <div class="widget">
                        <div class="widget-title">
                            <h6>Recent Comments</h6>
                        </div>
                    </div> --}}

                    <div class="widget">
                        <div class="widget-title">
                            <h6>Archives</h6>
                        </div>
                        <ul>
                            <li><a href="#0">{{ $post->published_at->format('F Y') }}</a></li>
                            <li><a href="#0">{{ $post->published_at->subMonth()->format('F Y') }}</a></li>
                            <li><a href="#0">{{ $post->published_at->subMonths(2)->format('F Y') }}</a></li>
                        </ul>
                    </div>

                    <div class="widget">
                        <div class="widget-title">
                            <h6>Categories</h6>
                        </div>
                        <ul>
                            @if($post->category)
                            <li><a href="{{ route('blog', ['category' => $post->category->slug]) }}">{{
                                    $post->category->name }}</a></li>
                            @endif
                            <li><a href="{{ route('blog') }}">All Posts</a></li>
                        </ul>
                    </div>



                </div>
            </div>

        </div>
    </div>
</section>
<!--====== End Blog ======-->

@push('styles')
<style>
    .post-content-body {
        text-align: left;
        margin: 20px 0;
    }

    .post-content-body p {
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .post-content-body h1,
    .post-content-body h2,
    .post-content-body h3,
    .post-content-body h4,
    .post-content-body h5,
    .post-content-body h6 {
        margin: 20px 0 10px 0;
        color: #333;
    }

    .post-content-body img {
        max-width: 100%;
        height: auto;
        margin: 15px 0;
        border-radius: 4px;
    }

    .post-content-body blockquote {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        margin: 20px 0;
        padding: 15px 20px;
        font-style: italic;
    }

    .post-content-body ul,
    .post-content-body ol {
        margin: 15px 0;
        padding-left: 30px;
    }

    .post-content-body li {
        margin-bottom: 5px;
    }
</style>
@endpush
@endsection