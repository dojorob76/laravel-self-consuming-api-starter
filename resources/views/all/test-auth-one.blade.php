@extends('app')

@section('content')
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
        <h2 class="text-center">
            Auth Test Success <small>(Query Test)</small>
        </h2>
        <hr>
        <p class="text-center">
            If you are viewing this page, your JWT was successfully set, and was authorized via the query string on
            the NON-API domain.
        </p>
        <p class="text-center">
            <a href="{{$mobile_route}}">Go to the <b>Mobile Subdomain</b></a> |
            <a href="{{$admin_route}}">Go to the <b>Admin Subdomain</b></a> |
            <a href="{{$main_route}}">Go to the <b>Main Domain</b></a>
        </p>
    </div>
@endsection