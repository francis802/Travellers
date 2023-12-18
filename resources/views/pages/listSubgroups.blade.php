@extends('layouts.app')
@include('partials.bar')


@section('content')

        @yield('bar')
        @if(count($subgroups) > 0) 
            @include('partials.subgroupList', ['subgroups' => $subgroups, 'group' => $group])
            @yield('subgroupList')
        @else
            <p>This group has no subgroups.</p>
        @endif

@endsection