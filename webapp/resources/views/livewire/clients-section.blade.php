<section id="clients" class="clients section-padding bg-gray" data-scroll-index="4">
    <div class="container">
        <div class="row">
            <!-- section heading -->
            <div class="section-head">
                <h3>Clients.</h3>
            </div>

            <!-- owl-carousel -->
            <div class="clients-carousel owl-carousel owl-theme">
                @foreach($clients as $client)
                <div class="item">
                    @if($client->website)
                    <a href="{{ $client->website }}" target="_blank" rel="noopener">
                        <img src="{{ \Storage::url($client->logo) }}" alt="{{ $client->name }}">
                    </a>
                    @else
                    <img src="{{ \Storage::url($client->logo) }}" alt="{{ $client->name }}">
                    @endif
                </div>
                @endforeach
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>