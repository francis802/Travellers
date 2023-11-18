@extends('layouts.app')
@include('partials.bar')
@include('partials.edit')

@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('edit')
    </section>
@endsection