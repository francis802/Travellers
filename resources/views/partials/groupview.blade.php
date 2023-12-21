@include('partials.topbar')

@section('groupview')
<section id="feed">
    @yield('topbar')
        <section id="group-presentation"> 
                @if ($group->banner_pic !== null)
                    <img src="{{ url($group->banner_pic) }}" class="img-fluid img-grp-banner" alt="...">
                @else
                    <img src="{{url('man.jpg')}}" alt="Profile Picture">
                @endif
                
                <div class="group-info">
                    <section id="profile-text">
                        <h2 id="group-name">{{ $group->country->name }}</h2>
                        <p>{{ $group->description }}</p>
                        <section id="group-infos">
                            <p class="infos-with-margin subgroups"><a href="{{ url('/group/'.$group->id.'/subgroups') }}">
                                {{ count($subgroups) }} Subgroups
                            </a></p>
                            <p class="infos-with-margin members"><a href="{{ url('/group/'.$group->id.'/members') }}">
                            {{ count($members) }} Members
                            </a></p>
                        </section>
                    </section>
                    <section id="profile-buttons-area">
                            @if(Auth::user()->isAdmin())
                                <a type="button" class="btn btn-primary" href="{{ url('/group/'.$group->id.'/edit') }}"> Edit </a>
                            @endif
                            @if (Auth::check() && Auth::user()->isMember($group->id))
                                <button type="button" class="leave-group btn btn-primary" data-id="{{$group->id}}"> Leave </button>
                            @else
                                <button type="button" class="join-group btn btn-primary" data-id="{{$group->id}}"> Join </button>
                            @endif
                            
                    </section>
                </div>
        </section>

        


        <section id="user-posts">
                @if(count($posts) > 0)
                    <ul id="user-post-list">
                        @foreach($posts as $post)
                            @include('partials.post', ['post' => $post])
                        @endforeach
                    </ul>
                @else
                    <p>This group has no posts.</p>
                @endif
        </section>
</section>
@endsection

