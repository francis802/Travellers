@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminReports')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminReports')
    </section>
@endsection