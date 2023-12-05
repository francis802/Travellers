@extends('layouts.app')
@include('partials.bar')
@include('partials.editGroupForm')

@section('content')
    
        @yield('bar')
        @yield('editGroupForm')
   
@endsection