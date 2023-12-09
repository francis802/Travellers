@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminHelps')



@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminHelps')
    </section>
@endsection