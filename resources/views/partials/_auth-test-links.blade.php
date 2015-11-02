<p>You are logged in!</p>
<a class="btn btn-default"
   href="{{route('test-auth-one.get', $jwtQuery)}}">
    NON-API Query String
</a>
<a class="btn btn-default ajax-link query"
   href="{{$dingo_v1->route('test-auth-two.get', $jwtQuery)}}">
    API Query String
</a>
<a class="btn btn-default ajax-link refresh"
   href="{{route('test-auth-three.get')}}">
    NON-API Header Refresh
</a>
<a class="btn btn-default ajax-link refresh"
   href="{{$dingo_v1->route('test-auth-four.get')}}">
    API Header Refresh
</a>
<hr>
<p class="test-message">
    Click the buttons to test the JWT using the Authorization header and/or Query string on
    different domains.
</p>
<h6 class="text-center">Hello, {{Auth::user()->name}}</h6>