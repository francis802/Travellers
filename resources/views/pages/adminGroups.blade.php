@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminGroups')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminGroups')
    </section>
@endsection