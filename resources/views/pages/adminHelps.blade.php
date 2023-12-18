@extends('layouts.app')

@section('title', 'Home')
@include('partials.adminbar')
@include('partials.helps')

@section('content')
    @yield('adminbar')
    @yield('helps')
@endsection