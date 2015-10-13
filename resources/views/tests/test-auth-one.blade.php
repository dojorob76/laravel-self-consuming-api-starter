@extends('webapp')

@section('content')
    <p class="text-center">
        You have successfully authorized via JWT on Test Route One. Try
        <a href="{{route('test-two.get')}}">Test Route Two</a> next to test persistence.
    </p>
@endsection