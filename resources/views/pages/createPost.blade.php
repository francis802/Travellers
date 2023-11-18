@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.createPostForm')

@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('createPostForm')
    </section>
@endsection