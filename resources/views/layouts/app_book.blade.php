<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles / Scripts -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    </head>
    <body>
        <header>
          <nav>
              <div class="mx-auto head nav-href" align="right">
                {{ auth()->user()->name }}
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" style="display: inline-block; margin-left: 20px;">
                    @csrf
                    <button type="submit" class="border">登出</button>
                </form>
              </div>
          </nav>
        </header>

        <main class="container">
            @yield('main')
        </main>
    </body>
</html>
