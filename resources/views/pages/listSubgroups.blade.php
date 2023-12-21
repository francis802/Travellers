@extends('layouts.app')
@include('partials.bar')

@section('title')
    Subgroups | Travellers
@endsection

@section('content')

        @yield('bar')
        
            @include('partials.subgroupList', ['subgroups' => $subgroups, 'group' => $group])
            @yield('subgroupList')
        

@endsection