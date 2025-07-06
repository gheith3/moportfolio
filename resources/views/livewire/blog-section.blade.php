<!--====== Blog ======-->
<section class="blog section-padding bg-gray" data-scroll-index="5">
    <div class="container">
        <div class="row">

            <!-- section heading -->
            <div class="section-head">
                <h3>My Blog.</h3>
            </div>

            <!-- owl carousel -->
            <div class="owl-carousel owl-theme">

                @foreach($blogPosts as $post)
                <!-- blog items -->
                <div class="pitem">
                    <div class="post-img">
                        @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                        @else
                        <img src="{{ asset('template/img/blog/1.jpg') }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="content">
                        <h6 class="tag">
                            <a href="#0">{{ $post->category->name ?? 'General' }}</a>
                        </h6>
                        <h4>
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                        <span class="more">
                            <a href="{{ route('blog.show', $post->slug) }}">Read More</a>
                        </span>
                    </div>
                </div>
                @endforeach

                @if($blogPosts->isEmpty())
                <!-- fallback items if no blog posts -->
                <div class="pitem">
                    <div class="post-img">
                        <img src="{{ asset('template/img/blog/1.jpg') }}" alt="Blog Post">
                    </div>
                    <div class="content">
                        <h6 class="tag">
                            <a href="#0">General</a>
                        </h6>
                        <h4>
                            <a href="#0">Welcome to Our Blog</a>
                        </h4>
                        <span class="more">
                            <a href="#0">Read More</a>
                        </span>
                    </div>
                </div>
                <div class="pitem">
                    <div class="post-img">
                        <img src="{{ asset('template/img/blog/2.jpg') }}" alt="Blog Post">
                    </div>
                    <div class="content">
                        <h6 class="tag">
                            <a href="#0">Technology</a>
                        </h6>
                        <h4>
                            <a href="#0">Latest Technology Trends</a>
                        </h4>
                        <span class="more">
                            <a href="#0">Read More</a>
                        </span>
                    </div>
                </div>
                <div class="pitem">
                    <div class="post-img">
                        <img src="{{ asset('template/img/blog/3.jpg') }}" alt="Blog Post">
                    </div>
                    <div class="content">
                        <h6 class="tag">
                            <a href="#0">Design</a>
                        </h6>
                        <h4>
                            <a href="#0">Modern Design Principles</a>
                        </h4>
                        <span class="more">
                            <a href="#0">Read More</a>
                        </span>
                    </div>
                </div>
                @endif

            </div>

        </div><!-- /row -->
    </div><!-- /container -->
</section>
<!--====== End Blog ======-->