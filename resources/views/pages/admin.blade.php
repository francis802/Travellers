@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminDashboard')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminDashboard')
    </section>
@endsection