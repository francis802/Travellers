@include('partials.topbar')


@section('subgroupList')
<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
            <section class="fst-grp-header">
                <h2 class="fst-grp">Subgroups</h2>
            </section>
            @if($subgroups->isEmpty())
                <p class="no-notifications">No subgroups yet...</p>
            @else
            <div id="groups-list"class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($subgroups as $subgroup)
                        <a href="{{ url('/group/'.$subgroup->id) }}">
                            <div class="col">
                                <div class="card">
                                @if($subgroup->banner_pic != null)
                                    <img src="{{ url($subgroup->banner_pic) }}" class="card-img-top">
                                @else
                                    <img src="{{ url('defaultBanner.png') }}" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{$subgroup->country->name}}</h5>
                                    <p class="card-text">{{ $subgroup->description }}</p>
                                </div>
                                </div>
                            </div>
                        </a>
                @endforeach
            </div>
            @endif
    </section>
    </section>
</section>


@endsection