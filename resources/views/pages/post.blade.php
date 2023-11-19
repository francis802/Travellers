@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.post')


@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('post')
    </section>
    
@endsection