@extends('layouts.app')

@include('partials.bar')
@include('partials.helps')

@section('title')
    Helps | Travellers
@endsection

@section('content')
    @yield('bar')
    @yield('helps')
@endsection
