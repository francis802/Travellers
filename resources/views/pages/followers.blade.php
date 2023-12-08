@extends('layouts.app')
@include('partials.bar')
@include('partials.followerInList', ['followers' => $followers, 'user' => $user])

@section('content')
<section class="inner-content">
    @yield('bar')
    @yield('followerInList')
</section>
@endsection
