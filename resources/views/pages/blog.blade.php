@extends('layouts.app')

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

<!-- ====== Blog Section ======  -->
<section class="blog section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- Blog posts will be loaded here -->
                <article class="post mb-50">
                    <div class="post-img">
                        <img src="{{ asset('template/images/blog/1.jpg') }}" alt="Blog Post">
                    </div>
                    <div class="content">
                        <div class="post-meta">
                            <span class="date">January 15, 2024</span>
                            <span class="category">
                                <a href="#0">Web Development</a>
                            </span>
                        </div>
                        <h2>
                            <a href="#0">Sample Blog Post Title</a>
                        </h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s...</p>
                        <a href="#0" class="more">Read More</a>
                    </div>
                </article>

                <!-- Pagination -->
                <div class="pagination">
                    <ul>
                        <li><a href="#0">1</a></li>
                        <li class="active"><a href="#0">2</a></li>
                        <li><a href="#0">3</a></li>
                        <li><a href="#0">Next</a></li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar">
                    <!-- Search -->
                    <div class="widget search-widget">
                        <h5>Search</h5>
                        <form>
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="widget categories-widget">
                        <h5>Categories</h5>
                        <ul>
                            <li><a href="#0">Web Development <span>(5)</span></a></li>
                            <li><a href="#0">Design <span>(3)</span></a></li>
                            <li><a href="#0">Technology <span>(7)</span></a></li>
                            <li><a href="#0">Tips & Tricks <span>(2)</span></a></li>
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="widget recent-posts-widget">
                        <h5>Recent Posts</h5>
                        <div class="recent-post">
                            <div class="post-img">
                                <img src="{{ asset('template/images/blog/2.jpg') }}" alt="Recent Post">
                            </div>
                            <div class="post-content">
                                <h6><a href="#0">Recent Post Title</a></h6>
                                <span class="date">January 10, 2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Blog Section ======  -->
@endsection