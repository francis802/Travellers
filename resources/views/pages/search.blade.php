@extends('layouts.app')
@include('partials.bar')
@include('partials.results')


@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('results')
    </section>
@endsection