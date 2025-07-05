<section id="about" class="hero section-padding pb-70" data-scroll-index="1">
    <div class="container">
        <div class="row">
            <!-- hero image -->
            <div class="col-md-5">
                <div class="hero-img mb-30">
                    <img src="{{ \Storage::url($profile->image ?? 'template/images/hero.jpg') }}"
                        alt="{{ $profile->name ?? 'Profile Picture' }}">
                </div>
            </div>

            <!-- content -->
            <div class="col-md-7">
                <div class="content mb-30">
                    <h3>About {{ $profile->name ?? 'Me' }}.</h3>
                    <span class="sub-title">{{ $profile->title ?? 'Developer' }}</span>
                    <p>{{ $profile->bio ?? 'Welcome to my portfolio!' }}</p>

                    <!-- skills progress -->
                    @if($profile->skills && $profile->skills->count() > 0)
                    <div class="skills">
                        @foreach($profile->skills as $skill)
                        <div class="item">
                            <div class="skills-progress">
                                <h6>{{ $skill->name }}</h6>
                                <span data-value="{{ $skill->percentage }}%"></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                    @endif

                    @if($profile->cv_file)
                    <a href="{{ asset($profile->cv_file) }}" download>
                        <span class="buton buton-bg">Download C.V</span>
                    </a>
                    @endif
                    <a href="#contact" data-scroll-nav="6">
                        <span class="buton">Contact Me</span>
                    </a>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>