@extends('webapp')

@section('content')
    <p class="text-center">
        You have successfully authorized via JWT on Test Route Two. You are now on a separate domain.
        Try <a href="{{$dingo_v1->route('test-one.get')}}">Test Route One</a> again to further test persistence.
    </p>
@endsection