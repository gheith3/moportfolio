<section id="contact" class="contact section-padding" data-scroll-index="6">
    <div class="container">
        <div class="row">
            <!-- section heading -->
            <div class="section-head">
                <h3>Contact Me.</h3>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <!-- contact info -->
                <div class="info text-center mb-50">
                    @if($profile && $profile->phone)
                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            <h6>Phone</h6>
                            <p>{{ $profile->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($profile && $profile->email)
                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            <h6>Email</h6>
                            <p>{{ $profile->email }}</p>
                        </div>
                    </div>
                    @endif

                    @if($profile && $profile->address)
                    <div class="col-md-4">
                        <div class="item">
                            <span class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <h6>Address</h6>
                            <p>{{ $profile->address }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="clearfix"></div>
                </div>

                <!-- Success/Error Messages -->
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <!-- contact form -->
                <form wire:submit="submit" class="form">
                    <div class="messages"></div>

                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input wire:model="name" type="text" placeholder="Name" required
                                        class="@error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input wire:model="email" type="email" placeholder="Email" required
                                        class="@error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input wire:model="phone" type="text" placeholder="Phone (Optional)"
                                        class="@error('phone') is-invalid @enderror">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input wire:model="subject" type="text" placeholder="Subject (Optional)"
                                        class="@error('subject') is-invalid @enderror">
                                    @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea wire:model="message" placeholder="Message" rows="4" required
                                        class="@error('message') is-invalid @enderror"></textarea>
                                    @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="buton buton-bg" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50">
                                    <span wire:loading.remove>Submit</span>
                                    <span wire:loading>Sending...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->
</section>