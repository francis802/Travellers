@extends('layouts.app')
@include('partials.bar')


@section('content')

        @yield('bar')
        
            @include('partials.memberInList', ['members' => $members, 'group' => $group])
            @yield('memberInList')
        

@endsection