@extends('layouts.app')
@include('partials.bar')
@include('partials.notificationTypes')


@section('content')
        @yield('bar')
        @yield('notificationTypes')
@endsection