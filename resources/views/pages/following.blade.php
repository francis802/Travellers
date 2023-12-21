@extends('layouts.app')
@include('partials.bar')
@include('partials.followingInList', ['following' => $following, 'user' => $user])

@section('title')
    Following | Travellers
@endsection

@section('content')
        @yield('bar')
        @yield('followingInList')
@endsection