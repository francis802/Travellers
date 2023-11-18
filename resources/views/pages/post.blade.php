@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')


@section('content')
    <section class="inner-content">
        @yield('bar')
        <section id="profile">
            <p>Travellers</p>
        </section>
    </section>
@endsection