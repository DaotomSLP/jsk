<!-- top navigation -->
<section class="ftco-section">
    <div class="container-fluid fixed-top px-0">
        <div class="justify-content-between" style="background-color: black">
            <div class="container order-md-last">
                <div class="row">
                    <div class="col-7" id="nav-logo">
                        <a class="navbar-brand d-flex justify-content-end justify-content-md-start" href="/"><img src="{{ URL::asset('/img/design/JSK-logo.jpeg') }}"
                                class="img-fluid" id="navbar-brand-logo"></a>
                    </div>
                    <div class="col-5 d-flex justify-content-end mb-md-0 mb-3 align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle Text-secondary" href="#"
                                id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ Config::get('languages')[App::getLocale()] }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @foreach (Config::get('languages') as $lang => $language)
                                    @if ($lang != App::getLocale())
                                        <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">
                                            {{ $language }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @if (isset(Auth::user()->name))
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle Text-secondary" href="#"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-user"></i> <p class="d-none d-md-inline">
                                        {{ Auth::user()->name }}
                                    </p>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="/profile">
                                        <span class="fa fa-user"> <i class="sr-only">user</i></span>
                                        {{ __('navbar.profile') }}
                                    </a>
                                    <a class="dropdown-item" href="/orders?status=success">
                                        <span class="fa fa-list-ul"> <i class="sr-only">list</i></span>
                                        {{ __('navbar.orders') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                        {{ __('navbar.logout') }}>
                                        <p>
                                            <span class="fa fa-sign-out"> <i class="sr-only">logout</i></span>
                                            {{ __('navbar.logout') }}
                                        </p>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            <button class="btn Btn-outline-secondary px-5" data-toggle="modal"
                                data-target="#loginModal-1">
                                {{ __('home.login') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light mt-0 mt-lg-5 pt-lg-2"
        id="ftco-navbar">
        {{-- <div class="container-fluid"> --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                        <a href="/home" class="nav-link">{{ __('home.home') }}</a>
                    </li>
                    <li class="nav-item dropdown {{ Request::is('plansByCategory/*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04111" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">{{ __('home.categories') }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04111">
                            @foreach ($categories as $category)
                                <a class="dropdown-item" href="/plansByCategory/{{ $category->id }}">
                                    {{ App::getLocale() == 'la' ? $category->cate_name : (App::getLocale() == 'en' ? ($category->cate_en_name ? $category->cate_en_name : $category->cate_name) : ($category->cate_cn_name ? $category->cate_cn_name : $category->cate_name)) }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <li
                        class="nav-item dropdown {{ Request::is('showPastWorks') || Request::is('showPresentWorks') || Request::is('showFutureWorks') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown04111" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">{{ __('home.project') }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04111">
                            <a class="dropdown-item" href="/showPastWorks">
                                {{ __('home.past_project') }}
                            </a>
                            <a class="dropdown-item" href="/showPresentWorks">
                                {{ __('home.present_project') }}
                            </a>
                            <a class="dropdown-item" href="/showFutureWorks">
                                {{ __('home.future_project') }}
                            </a>
                        </div>
                    </li>
                    <li class="nav-item {{ Request::is('lamps') ? 'active' : '' }}">
                        <a href="/lamps" class="nav-link">JA Lighting</a>
                    </li>
                </ul>
            </div>
        {{-- </div> --}}
    </nav>

    <div id="social-float-div" class="card card-body p-2 bg-dark rounded-0">
        <div class="social-media mb-2">
            <p class="mb-0 d-flex">
                <a href="https://www.facebook.com/Jskgroup.lao" target="_blank"
                    class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i
                            class="sr-only">Facebook</i></span></a>
            </p>
        </div>
        <div class="social-media mb-2">
            <p class="mb-0 d-flex">
                <a href="https://wa.me/8562055966596" target="_blank"
                    class="d-flex align-items-center justify-content-center"><span class="fa fa-whatsapp"><i
                            class="sr-only">Whatsapp</i></span></a>
            </p>
        </div>
    </div>
    <!-- END nav -->

    <div class="modal fade mt-5" id="loginModal-1" tabindex="-1" role="dialog" aria-labelledby="loginLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-dark card-shadow" bis_skin_checked="1">
                        <div class="card-body p-5">
                            <div class="pb-3">
                                <img src="{{ URL::asset('/img/design/JSK-logo.jpeg') }}" class="img-fluid"
                                    style="max-height: 50px">
                            </div>
                            <p class="h3 Text-secondary text-uppercase mb-2 mt-3">{{ __('home.login') }}</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group my-4">
                                    <span class="input-group-text" id="email">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="email"
                                        aria-label="email" aria-describedby="email" name="email" required>
                                </div>
                                <div class="input-group my-4">
                                    <span class="input-group-text" id="password">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="password"
                                        aria-label="password" aria-describedby="password" name="password" required>
                                </div>
                                <div class="my-4">
                                    <button type="submit" class="btn Btn-outline-secondary px-5">
                                        {{ __('home.login') }}
                                    </button>
                                </div>
                                <hr />
                                <p class="text-white mb-0">
                                    {{ __('home.do_you_have_account') }}
                                </p>
                                <a href="/register">
                                    <p class="text-white mb-0 text-underline">
                                        {{ __('home.register') }}
                                    </p>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
