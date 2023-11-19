@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminreports')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminreports')
    </section>
@endsection