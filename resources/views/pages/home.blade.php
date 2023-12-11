@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.feed')

@section('content')
    
        @yield('bar')
        @yield('feed')
    
@endsection

