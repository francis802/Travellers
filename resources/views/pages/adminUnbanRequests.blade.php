@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminUnbanRequests')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminUnbanRequests')
    </section>
@endsection