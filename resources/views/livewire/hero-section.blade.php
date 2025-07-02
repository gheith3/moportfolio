<section id="home" class="header" data-scroll-index="0"
    style="background-image: url({{ asset($profile->background_image ?? 'template/images/bg.jpg') }});"
    data-stellar-background-ratio="0.8">
    <div class="v-middle">
        <div class="container">
            <div class="row">
                <!-- caption -->
                <div class="caption">
                    <h5>{{ $profile->greeting ?? 'Hello' }}</h5>
                    <h1 class="cd-headline clip">
                        <span class="blc">{{ $profile->greeting ?? 'Hello, I am' }} </span>
                        <span class="cd-words-wrapper">
                            @if($profile->animated_texts)
                            @foreach($profile->animated_texts as $index => $text)
                            <b class="{{ $index === 0 ? 'is-visible' : '' }}">{{ $text }}</b>
                            @endforeach
                            @else
                            <b class="is-visible">Developer</b>
                            <b>Designer</b>
                            <b>Creator</b>
                            @endif
                        </span>
                    </h1>

                    <!-- social icons -->
                    <div class="social-icon">
                        @if($profile->social_links)
                        @foreach($profile->social_links as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener">
                            <span><i class="{{ $social['icon'] }}" aria-hidden="true"></i></span>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
                <!-- end caption -->
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>