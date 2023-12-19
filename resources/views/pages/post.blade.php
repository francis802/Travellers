@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    
        @yield('bar')

        @if(url()->current() == url('/post/'.$post->id))
            <section id="feed">
                @yield('topbar')
                @include('partials.post')
            </section>
        @else
            @include('partials.post')
        @endif
@endsection