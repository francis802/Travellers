@extends('layouts.app')
@include('partials.bar')
@include('partials.followerInList', ['followers' => $followers, 'user' => $user])

@section('content')
    @yield('bar')
    @yield('followerInList')
@endsection
