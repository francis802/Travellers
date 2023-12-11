@extends('layouts.app')
@include('partials.bar')
@include('partials.followingInList', ['following' => $following, 'user' => $user])

@section('content')
        @yield('bar')
        @yield('followingInList')
@endsection