<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Favicon (Replace the 'favicon.ico' file in public directory to customize this) -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Base CSS -->
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
        <!-- Base jQuery -->
        <script src="{{ elixir('js/all.js') }}"></script>

    </head>

    <body id="app"><!--This ID corresponds to the main Vue.js File (resources/assets/js/vue/app.js)-->

        <div class="container-fluid">
            <!-- Load Page Content -->
            @yield('content')
        </div>

        <!-- Vue Core Script -->
        <script src="{{ elixir('js/bundle.js') }}"></script>
    </body>

</html>