@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.feed')

@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('feed')
    </section>
@endsection

