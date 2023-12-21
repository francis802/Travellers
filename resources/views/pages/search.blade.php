@extends('layouts.app')
@include('partials.bar')
@include('partials.results')

@section('title')
    Search | Travellers
@endsection

@section('content')
    
        @yield('bar')
        @yield('results')
  
@endsection