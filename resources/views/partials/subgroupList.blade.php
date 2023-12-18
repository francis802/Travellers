@include('partials.topbar')


@section('subgroupList')
<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
        <h2>Subgroups</h2>
        <ul class="list-group list-group-flush">
        @foreach($subgroups as $subgroup)
            <li class="list-group-item list-group-item-light">
                <a href="{{ url('/group/'.$subgroup->id) }}">
                    <div class="notification-info">
                        <img width="40em" height="40em" src="{{ url($subgroup->banner_pic) }}">
                        <p class="notification-text">{{$subgroup->country->name}}</p>
                    </div>
                </a>
            </li>
        @endforeach
        </ul>
    </section>
</section>
@endsection