@extends('layouts.app')
@include('partials.bar')
@include('partials.notificationTypes')

@section('title')
    Notifications | Travellers
@endsection

@section('content')
        @yield('bar')
        @yield('notificationTypes')
@endsection