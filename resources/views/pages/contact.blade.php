@extends('layouts.app')

@section('title', 'Contact - Portfolio')
@section('description', 'Get in touch with me for your next project')
@section('keywords', 'contact, hire, freelance, web development, design')

@section('content')
<!-- ====== Header ======  -->
<section class="header-contact">
    <div class="v-middle">
        <div class="container">
            <div class="row">
                <div class="caption">
                    <h1>Contact</h1>
                    <span>Let's work together</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== End Header ======  -->

<!-- ====== Contact Section ======  -->
<section class="contact section-padding">
    <div class="container">
        <div class="row">
            <!-- section heading -->
            <div class="section-head">
                <h3>Get In Touch.</h3>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <!-- contact info -->
                <div class="info text-center mb-50">
                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-location-arrow" aria-hidden="true"></i></span>
                            <h6>Address</h6>
                            <p>Your Address Here<br>City, Country</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            <h6>Email</h6>
                            <p>your.email@example.com</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            <h6>Phone</h6>
                            <p>+1 234 567 8900</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <!-- contact form -->
                <form class="form" id="contact-form" method="post" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="messages"></div>

                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_name" type="text" name="name" placeholder="Name" required="required"
                                        value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_email" type="email" name="email" placeholder="Email"
                                        required="required" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="form_subject" type="text" name="subject" placeholder="Subject"
                                        value="{{ old('subject') }}">
                                    @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="form_message" name="message" placeholder="Message" rows="6"
                                        required="required">{{ old('message') }}</textarea>
                                    @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="submit" value="Send Message" class="buton buton-bg">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Social Links -->
                <div class="social-links text-center mt-50">
                    <h6>Follow Me</h6>
                    <div class="social-icon">
                        <a href="#0" target="_blank">
                            <span><i class="fa fa-facebook" aria-hidden="true"></i></span>
                        </a>
                        <a href="#0" target="_blank">
                            <span><i class="fa fa-twitter" aria-hidden="true"></i></span>
                        </a>
                        <a href="#0" target="_blank">
                            <span><i class="fa fa-linkedin" aria-hidden="true"></i></span>
                        </a>
                        <a href="#0" target="_blank">
                            <span><i class="fa fa-github" aria-hidden="true"></i></span>
                        </a>
                        <a href="#0" target="_blank">
                            <span><i class="fa fa-youtube" aria-hidden="true"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>
<!-- ====== End Contact Section ======  -->
@endsection