<!--====== References ======-->
<section id="references" class="clients section-padding bg-gray" data-scroll-index="4">
    <div class="container">
        <div class="row">

            <!-- section heading -->
            <div class="section-head">
                <h3>References.</h3>
            </div>

            <!-- owl carousel -->
            <div class="col-md-offset-1 col-md-10">
                <div class="owl-carousel owl-theme text-center">

                    @foreach($references as $reference)
                    <!-- reference items -->
                    <div class="citem">
                        {{-- <div class="author-img">
                            <i class="fa fa-user-circle fa-5x" style="color: #ddd;"></i>
                        </div> --}}
                        <h3>{{ $reference->name }}</h3>
                        <p>{{ $reference->slogan }}</p>
                        <span>
                            <a href="mailto:{{ $reference->email }}" style="color: #666; text-decoration: none;">{{
                                $reference->email }}</a>
                            <br>
                            <a href="tel:{{ $reference->phone }}" style="color: #666; text-decoration: none;">{{
                                $reference->phone }}</a>
                        </span>
                    </div>
                    @endforeach

                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>
<!--====== End References ======-->