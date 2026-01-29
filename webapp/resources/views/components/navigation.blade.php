<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#nav-icon-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- logo -->
            <a class="logo" href="{{ route('home') }}">{{ config('app.name', 'Portfolio') }}</a>
        </div>

        <!-- Collect the nav links, and other content for toggling -->
        <div class="collapse navbar-collapse" id="nav-icon-collapse">
            <!-- links -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}#about">About</a></li>
                <li><a href="{{ route('home') }}#services">Services</a></li>
                <li><a href="{{ route('home') }}#works">Works</a></li>
                <li><a href="{{ route('home') }}#references">References</a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">Blog</a>
                </li>
                <li><a href="{{ route('home') }}#contact">Contact</a></li>
                {{-- <li><a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li> --}}
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>