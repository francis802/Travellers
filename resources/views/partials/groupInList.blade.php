@include('partials.topbar')


@section('groupInList')
   
    <section id="feed">
        @yield('topbar')
        <section class="notifications-container" >
            <h2>Groups</h2>
            @if($groups->isEmpty())
                <p >You´re not in any group yet..</p>
            @else
            <div id="groups-list"class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($groups as $group)
                        <a href="{{ url('/group/'.$group->id) }}">
                            <div class="col">
                                <div class="card">
                                @if($group->banner_pic != null)
                                <img src="{{ url($group->banner_pic) }}" class="card-img-top">
                                @else
                                    <img src="{{ url('../defaultBanner.png') }}" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{$group->country->name}}</h5>
                                    <p class="card-text">{{ $group->description }}</p>
                                </div>
                                </div>
                            </div>
                        </a>
                @endforeach
            </div>
            @endif
        </section>
    </section>
    
@endsection