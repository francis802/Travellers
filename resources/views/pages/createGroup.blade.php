@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.createGroupForm')

@section('content')
    
        @yield('bar')
        @yield('createGroupForm')
   
@endsection