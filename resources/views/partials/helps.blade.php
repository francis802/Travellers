@include('partials.topbar')

@section('helps')

<section id="feed">
    @yield('topbar')

    <div class="d-grid gap-2 col-6 mx-auto">
    <a class="btn btn-danger" href="{{url('/help/create/')}}">Create Help</a>
    </div>

    <section id="buttons">
        <button id="open-help-button" class="underline">Open Helps</button>
        <button id="close-help-button">Closed Helps</button>
    </section>

    @include('partials.helpsList', ['helps' => $openedHelps, 'type' => 'open-help'])

    @include('partials.helpsList', ['helps' => $closedHelps, 'type' => 'close-help'])

</section>
@endsection
