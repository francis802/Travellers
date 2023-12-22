@extends('layouts.app')
@include('partials.bar')

@section('title')
    Groups | Travellers
@endsection


@section('content')
    
        @yield('bar')
        @if(count($groups) > 0)
            @include('partials.groupInList', ['groups' => $groups])
            @yield('groupInList')
                
        @endif
@endsection