@extends('layouts.app')
@include('partials.bar')
@include('partials.results')


@section('content')
    
        @yield('bar')
        @yield('results')
  
@endsection