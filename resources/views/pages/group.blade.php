@extends('layouts.app')
@include('partials.bar')
@include('partials.groupview')

@section('title')
    Group | Travellers
@endsection

@section('content')
    
        @yield('bar')
        @yield('groupview')
    
    
@endsection