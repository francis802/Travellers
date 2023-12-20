@extends('layouts.app')
@include('partials.adminbar')
@include('partials.adminDashboard')



@section('content')
    
    @yield('adminbar')
    @yield('adminDashboard')

@endsection