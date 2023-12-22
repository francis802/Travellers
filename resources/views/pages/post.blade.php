@extends('layouts.app')

@include('partials.bar')
@include('partials.topbar')

@section('title')
    Post | Travellers
@endsection

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