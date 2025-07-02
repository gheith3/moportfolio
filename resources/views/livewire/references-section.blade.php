<section id="references" class="references section-padding bg-gray" data-scroll-index="4">
    <div class="container">
        <!-- section heading -->
        <div class="section-head">
            <h3>References.</h3>
        </div>

        <div class="row">
            @foreach($references as $reference)
            <div class="col-md-4 col-sm-6">
                <div class="reference-item">
                    <div class="reference-content">
                        <div class="reference-header">
                            <h5 class="reference-name">{{ $reference->name }}</h5>
                            <p class="reference-slogan">{{ $reference->slogan }}</p>
                        </div>
                        <div class="reference-contact">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $reference->email }}">{{ $reference->email }}</a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $reference->phone }}">{{ $reference->phone }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div><!-- /row -->
    </div><!-- /container -->
</section>

@push('css')

<style>
    .reference-item {
        background: #fff;
        padding: 30px 20px;
        margin-bottom: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
    }

    .reference-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .reference-header {
        margin-bottom: 20px;
    }

    .reference-name {
        color: #333;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .reference-slogan {
        color: #666;
        font-size: 14px;
        font-style: italic;
        margin-bottom: 0;
    }

    .reference-contact {
        margin-top: 15px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .contact-item i {
        margin-right: 8px;
        width: 16px;
        color: #007bff;
    }

    .contact-item a {
        color: #555;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-item a:hover {
        color: #007bff;
    }

    @media (max-width: 768px) {
        .reference-item {
            margin-bottom: 20px;
        }
    }
</style>
@endpush