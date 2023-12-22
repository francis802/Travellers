@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')

@section('title')
    Report Management | Travellers
@endsection

@section('content')
    @yield('adminbar')
    <section id="feed">
        @yield('topbar')
        <section id="buttons">
            <button id="open-help-button" class="underline">Open Reports</button>
            <button id="close-help-button">Closed Reports</button>
        </section>

        @include('partials.reportsList', ['reports' => $openedReports, 'type' => 'open-help'])

        @include('partials.reportsList', ['reports' => $closedReports, 'type' => 'close-help'])

    </section>
@endsection