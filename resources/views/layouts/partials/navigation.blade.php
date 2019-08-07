<header class="header-global">
    <nav id="navbar-main" class="navbar fixed-top navbar-main navbar-expand-lg navbar-white bg-white">
        <div class="container container-wide">
            <a class="navbar-brand mr-lg-5" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" height="65">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{ route('home') }}">
                                <!--img src="{{ asset('img/logo.png') }}" height="65"-->
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link" role="button">
                            <i class="ni ni-ui-04 d-lg-none"></i>
                            <span class="nav-link-inner--text font-weight-bold">Home</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>