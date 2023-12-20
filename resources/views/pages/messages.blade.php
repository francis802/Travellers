@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')

        </section>
   
@endsection