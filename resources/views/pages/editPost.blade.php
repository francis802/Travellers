@extends('layouts.app')
@include('partials.bar')
@include('partials.editPostForm')

@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('editPostForm')
    </section>
@endsection