@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')

@section('title')
    Unban Requests | Travellers
@endsection

@section('content')
    @yield('adminbar')
    <section id="feed">
        @yield('topbar')
        <section id="buttons">
            <button id="open-help-button" class="underline">Open Appeals</button>
            <button id="close-help-button">Closed Appeals</button>
        </section>

        @include('partials.appealsList', ['appeals' => $openedAppeals, 'type' => 'open-help'])

        @include('partials.appealsList', ['appeals' => $closedAppeals, 'type' => 'close-help'])

    </section>
@endsection