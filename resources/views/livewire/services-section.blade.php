<section id="services" class="services section-padding bg-gray text-center pb-70" data-scroll-index="2">
    <div class="container">
        <!-- section heading -->
        <div class="section-head">
            <h3>Services.</h3>
        </div>

        <div class="row">
            @foreach($services as $service)
            <div class="col-md-4">
                <div class="item">
                    <span class="icon"><i class="{{ $service->icon }}" aria-hidden="true"></i></span>
                    <h6>{{ $service->title }}</h6>
                    <p>{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div><!-- /row -->
    </div><!-- /container -->
</section>