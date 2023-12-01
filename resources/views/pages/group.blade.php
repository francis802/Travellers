@extends('layouts.app')
@include('partials.bar')
@include('partials.groupview')


@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('groupview')
    </section>
    
@endsection