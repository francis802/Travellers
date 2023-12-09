@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')


@section('content')
    <section class="inner-content">
        @yield('bar')
        @include('partials.post')
    </section>
    
@endsection