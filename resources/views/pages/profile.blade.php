@extends('layouts.app')
@include('partials.bar')
@include('partials.user')


@section('content')
   
    @yield('bar')
    @yield('user')
   
@endsection