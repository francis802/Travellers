@extends('layouts.app')
@include('partials.bar')
@include('partials.user')

@section('title')
    Profile | Travellers
@endsection

@section('content')
   
    @yield('bar')
    @yield('user')
   
@endsection