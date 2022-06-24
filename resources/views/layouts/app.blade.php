<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @livewireStyles

</head>
<style>
    @font-face {
        src: url('{{ asset('assets/fonts/Montserrat-Regular.ttf') }}');
        font-family: "Montserrat";
    }
    *{
        font-family: Montserrat;
    }
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="d-block d-sm-none">
                       <img style="height: 50px" src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo of university of guelma">
                    </div>
                    <div class="d-none d-sm-block">
                        <img class="w-50" src="{{ asset('assets/images/logo.png') }}" alt="Logo of university of guelma">
                     </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Se connecter') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register') && App\Models\Session::where('status','inscription')->count())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('S\'inscrire') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link mx-3 fw-bold" href="{{ route('home') }}">
                                    <i class="fas fa-home"></i> Accueil
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user mx-2"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Se déconnecter') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        {{-- footer --}}

        <div class="container-fluid bg-light">
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 p-5 mt-5 border-top justify-content-between">
              <div class="col mb-3 text-center">
                <a href="https://www.univ-guelma.dz" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
                  <img class="w-75" src="{{ asset('assets/images/logo.png') }}" alt="Univerity logo">
                </a>
              </div>

              <div class="col mb-3">
                <h5 class="fw-bold">Contacte</h5>
                <ul class="nav flex-column fw-bold text-muted">
                  <li class="nav-item mb-2"><a href="https://www.univ-guelma.dz" class="nav-link p-0 text-info text-decoration-underline">Université 8 mai 1945 - GUELMA</a></li>
                  <li class="nav-item mb-2"><i class="fas fa-phone"></i> 213 (0) 37 10 05 53</li>
                  <li class="nav-item mb-2"><i class="fas fa-fax"></i> 213 (0) 37 10 05 55</li>
                  <li class="nav-item mb-2"><i class="fas fa-location-arrow"></i> BP 401 GUELMA 24000 - ALGERIE</li>
                </ul>
              </div>

              <div class="col mb-3">
                <h5 class="fw-bold">Développeurs</h5>
                <ul class="nav flex-column fw-bold">
                  <li class="nav-item mb-2"><a href="https://github.com/yunes-allal" class="nav-link p-0"><i class="fab fa-github"></i> Younes Allal</a></li>
                  <li class="nav-item mb-2"><a href="https://github.com/manarbensa" class="nav-link p-0"><i class="fab fa-github"></i> Manar Bensaada</a></li>
                  <p class="text-muted fw-light">&copy; 2022</p>
                </ul>
              </div>
            </footer>
          </div>
    </div>

    @livewireScripts
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Jquery CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    @if(Session::has('success'))
        <script>
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.options.positionClass = "toast-bottom-right"
            toastr.success("{{ Session::get('success') }}");
        </script>
    @endif
    @if(Session::has('fail'))
        <script>
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.options.positionClass = "toast-bottom-right"
            toastr.error("{{ Session::get('fail') }}");
        </script>
    @endif
    @if(Session::has('info'))
        <script>
            toastr.options.progressBar = true;
            toastr.options.positionClass = "toast-bottom-right"
            toastr.info("{{ Session::get('info') }}");
        </script>
    @endif
</body>
</html>
