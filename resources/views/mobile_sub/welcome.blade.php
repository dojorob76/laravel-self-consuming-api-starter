@extends('app')

@section('content')
    <!-- Load Vue Page Content -->
    <component :is="currentView"></component>

    @if(Auth::check())
        <h6 class="text-center">Hello, {{Auth::user()->name}}</h6>
    @endif
@endsection

@section('postscripts')
    <!-- Vue Core Script -->
    <script src="{{ elixir('js/bundle.js') }}"></script>
@endsection