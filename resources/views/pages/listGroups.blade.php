@extends('layouts.app')
@include('partials.bar')




@section('content')
    <section class="inner-content">
        @yield('bar')
        @if(count($groups) > 0)
            <ul id="group-list">
                
                    @include('partials.groupInList', ['groups' => $groups])
                    @yield('groupInList')
                
            </ul>
        @endif
    </section>
@endsection