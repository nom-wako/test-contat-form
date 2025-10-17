<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FashionablyLate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <h1 class="header__logo"><a href="/" class="header__logo-link">FashionablyLate</a></h1>
      @php
      $route = Route::currentRouteName();
      @endphp
      @if(in_array($route, ['login', 'register', 'admin']))
      <nav class="header__nav">
        <ul class="header__menu">
          @if($route === 'login')
          <li class="header__menu-item">
            <a href="/register" class="header__menu-button">register</a>
          </li>
          @elseif($route === 'register')
          <li class="header__menu-item">
            <a href="/login" class="header__menu-button">login</a>
          </li>
          @elseif($route === 'admin')
          @if(Auth::check())
          <li class="header__menu-item">
            <form action="/logout" method="post">
              @csrf
              <button class="header__menu-button">logout</button>
            </form>
          </li>
          @endif
          @endif
        </ul>
      </nav>
      @endif
    </div>
  </header>
  <main>
    @yield('content')
  </main>
</body>

</html>
