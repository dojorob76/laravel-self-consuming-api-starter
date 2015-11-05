<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

        <title></title>

        <!-- Favicon (Replace the 'favicon.ico' file in public directory to customize this) -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Base CSS -->
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
        <!-- Base jQuery -->
        <script src="{{ elixir('js/all.js') }}"></script>

        <!-- AJAX Set Up -->
        <script>
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': appGlobals.csrf, 'Authorization': jwToken.setHeader()}});
        </script>
    </head>

    <body id="app"><!--This ID corresponds to the root Vue.js File (resources/assets/js/vue/app.js)-->
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand" href="{{$main_route}}">
                      <span class="glyphicon glyphicon-home"></span>
                  </a>
              </div>
              <ul class="nav navbar-nav">
                  <li><a href="/intro">Intro</a></li>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                         aria-expanded="false">Subdomains <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="{{$mobile_route}}">Mobile</a></li>
                          <li><a href="{{$admin_route}}">Admin</a></li>
                      </ul>
                  </li>
              </ul>
              <div class="navbar-right" style="margin-right: 15px;">
                  @if(Auth::check())
                    <a class="btn btn-default navbar-btn" href="/logout">Log Out</a>
                  @endif
              </div>
          </div>
        </nav>

        <div class="container-fluid">
            <!-- Load Page Content -->
            @yield('content')
        </div>

        <!-- Load Footer JS -->
        @yield('postscripts')
    </body>

</html>