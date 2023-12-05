@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.createPostForm')

@section('content')
        @yield('bar')
        @yield('createPostForm')
@endsection