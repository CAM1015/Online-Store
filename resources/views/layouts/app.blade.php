<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=NTR&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

  <link rel="icon" href="{{ asset('faviconBolso.PNG') }}" type="image/x-icon" />

  <title>@yield('title', __('messages.store_name'))</title>

  <style>
    /* Definir colores personalizados */
    :root {
      --color-primary: #FD554F; /* Rojo */
      --color-secondary: #13DCBE; /* Verde agua */
      --color-accent: #FCBE27; /* Amarillo */
      --color-dark: #196EA4; /* Azul */
      --color-white: #FFFFFF; /* Blanco */
    }

    /* Fondo blanco para toda la página */
    body {
      background-color: var(--color-white);
    }

    /* Cambiar el fondo del navbar */
    .navbar {
      background-color: var(--color-dark) !important; /* Azul */
    }

    /* Cambiar el color de los enlaces del navbar */
    .navbar-nav .nav-link {
      color: var(--color-white) !important;
    }

    /* Cambiar color de los enlaces del navbar cuando pasas el mouse */
    .navbar-nav .nav-link:hover {
      color: var(--color-secondary) !important; /* Verde agua */
    }

    /* Cambiar el fondo del header */
    .masthead {
      background-color: var(--color-primary) !important; /* Rojo */
    }

    /* Cambiar el texto en el header */
    .masthead h2 {
      color: var(--color-white) !important;
    }

    /* Cambiar el fondo y color del footer */
    .copyright {
      background-color: var(--color-dark) !important; /* Azul */
      color: var(--color-white) !important;
    }

    .copyright a {
      color: var(--color-accent) !important; /* Amarillo */
    }

    .copyright a:hover {
      color: var(--color-secondary) !important; /* Verde agua */
    }

    #navbarDropdownMenuLink {
      color: var(--color-primary) !important;
    }

    .dropdown-menu a {
      color: var(--color-primary) !important;
    }

    .nav-link.active {
      color: var(--color-accent) !important;
    }

  </style>
</head>
<body>
  <!-- header -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-4">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home.index') }}">{{ __('messages.store_name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link active" href="{{ route('home.index') }}">{{ __('messages.store_home') }}</a>
          <a class="nav-link active" href="{{ route('product.index') }}">{{ __('messages.store_products') }}</a>
          <a class="nav-link active" href="{{ route('cart.index') }}">{{ __('messages.store_cart') }}</a></a>
          <a class="nav-link active" href="{{ route('home.about') }}">{{ __('messages.store_about') }}</a>
          <div class="vr bg-white mx-2 d-none d-lg-block"></div>
          @guest
          <a class="nav-link active" href="{{ route('login') }}">{{ __('messages.login') }}</a>
          <a class="nav-link active" href="{{ route('register') }}">{{ __('messages.register') }}</a>
          @else
           <!-- Mensaje de bienvenida al usuario autenticado -->
           <span class="nav-link active">Hola, {{ Auth::user()->name }}</span>

           <a class="nav-link active" href="{{ route('myaccount.orders') }}">{{ __('messages.my_orders') }}</a>
 
           <form id="logout" action="{{ route('logout') }}" method="POST">
             <a role="button" class="nav-link active"
                onclick="document.getElementById('logout').submit();">{{ __('messages.logout') }}</a>
            @csrf
          </form>
          @endguest

          <!-- Dropdown para cambiar idioma -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Config::get('languages')[App::getLocale()] }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            @foreach (Config::get('languages') as $lang => $language)
                @if ($lang != App::getLocale())
                        <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a>
                @endif
            @endforeach
            </div>
        </li>

        </div>
      </div>
    </div>
  </nav>

  <header class="masthead bg-primary text-white text-center py-4">
    <div class="container d-flex align-items-center flex-column">
      <h2>{{ __('messages.subtitle') }}</h2>
    </div>
  </header>
  <!-- header -->

  <div class="container my-4">
    @yield('content')
  </div>

  <!-- footer -->
  <div class="copyright py-4 text-center text-white">
    <div class="container">
      <small>
        {{ __('messages.copyright') }} - <a class="text-reset fw-bold text-decoration-none" target="_blank"
          href="https://twitter.com/danielgarax">
          Daniel Correa
        </a> - <b>Paola Vallejo</b>
      </small>
    </div>
  </div>
  <!-- footer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
</body>
</html>
