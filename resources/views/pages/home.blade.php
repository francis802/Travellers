@extends('layouts.app')


@include('partials.bar')
@include('partials.feed')

@section('title')
    Home | Travellers
@endsection

@section('content')
    
        @yield('bar')
        @yield('feed')
    
@endsection

