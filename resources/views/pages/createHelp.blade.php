@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.createHelp')

@section('content')
        <section class="inner-content">
                @yield('bar')
                @yield('createHelp')
        </section>
@endsection
