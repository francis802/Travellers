@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')



@section('content')
    
    @yield('adminbar')
    <section id="feed">
        @yield('topbar')
        <h1>Admin Console</h1>
        <h3> Welcome {{Auth::user()->name}}!</h3>
        <p>
            You have successfully logged into the Admin Console. This powerful tool allows you to manage and oversee various aspects of your application.
        </p>

    </section>

@endsection