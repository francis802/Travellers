@extends('layouts.app')
@include('partials.bar')
@include('partials.user')

@section('content')
    <section class="inner-content">
    @yield('bar')
    @yield('user')
    </section>
@endsection