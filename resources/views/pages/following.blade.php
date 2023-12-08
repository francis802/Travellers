@extends('layouts.app')
@include('partials.bar')
@include('partials.followingInList', ['following' => $following, 'user' => $user])

@section('content')
    <section class="inner-content">
        @yield('bar')
        @yield('followingInList')
    </section>
@endsection