@extends('layouts.app')
@include('partials.bar')




@section('content')
    <section class="inner-content">
        @yield('bar')
        @if(count($members) > 0)
            <ul id="group-list">
                
                    @include('partials.memberInList', ['members' => $members])
                    @yield('memberInList')
                
            </ul>
        @endif
    </section>
@endsection