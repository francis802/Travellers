@extends('layouts.app')
@include('partials.bar')
@include('partials.groupview')


@section('content')
    
        @yield('bar')
        @yield('groupview')
    
    
@endsection