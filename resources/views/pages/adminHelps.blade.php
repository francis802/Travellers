@extends('layouts.app')

@include('partials.adminbar')
@include('partials.helps')

@section('title')
    Help Management | Travellers
@endsection

@section('content')
    @yield('adminbar')
    @yield('helps')
@endsection