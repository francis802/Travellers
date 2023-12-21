@extends('layouts.app')
@include('partials.topbar')

@section('title')
    Banned | Travellers
@endsection

@section('content')
    <section id="feed">
        @yield('topbar')
        <section class="banned text-center">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h1 class="display-4">Sorry, you are banned from this site.</h1>
                        <p class="lead">You have been banned for violating our community guidelines.</p>
                        <p class="lead">You have been banned for {{ $time_since_ban }}.</p>
                        <p class="lead">If you believe this is a mistake, please contact our support team.</p>
                        <div class="banned-buttons mt-4">
                            <a href="{{ url('/logout') }}" class="btn btn-outline-danger btn-lg">Logout</a>
                            <a href="{{ url('/appeal-unban') }}" class="btn btn-danger btn-lg">Appeal Unban</a>
                        </div>
                        <br>
                        <p class="lead"><strong>Otherwise, your ban will last indefinitely.<strong></p>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
