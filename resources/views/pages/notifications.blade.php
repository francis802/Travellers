@extends('layouts.app')
@include('partials.bar')
@include('partials.notificationTypes')


@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('notificationTypes')
    </section>
@endsection