@extends('layouts.default')

@section('title', 'KARUTA')

@section('content')
@if (! is_array(\Session::get('accessToken')))
Let's play KARUTA with Instagram photos. Please login.
@else
<a href="{{ url('karuta') }}" class="btn btn-default">Play KARUTA</a>
@endif
@stop
