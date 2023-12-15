@extends('layouts.app')
@include('partials.bar')


@section('content')

        @yield('bar')
        @if(count($members) > 0)
            @include('partials.memberInList', ['members' => $members, 'group' => $group])
            @yield('memberInList')
        @endif

@endsection