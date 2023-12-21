@extends('layouts.app')
@include('partials.bar')
@include('partials.followerInList', ['followers' => $followers, 'user' => $user])

@section('title')
    Followers | Travellers
@endsection

@section('content')
    @yield('bar')
    @yield('followerInList')
@endsection
