@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminUsers')

@section('title')
    User Management | Travellers
@endsection

@section('content')
    <section class="inner-content">
    @yield('adminbar')
    @yield('adminUsers')
    </section>
@endsection