@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.helps')

@section('content')
    @yield('bar')
    @yield('helps')
@endsection
