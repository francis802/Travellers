@include('partials.topbar')

@section('groupview')
<section id="feed">
    @yield('topbar')
        <section id="user-presentation"> 
            <div id="profile-picture">
                @if ($group->banner_pic !== null)
                    <img src="{{ url($group->banner_pic) }}">
                @else
                    <img src="{{url('man.jpg'}}" alt="Profile Picture">
                @endif
            </div>
                <section id="profile-text">
                    <h3 id="user-name">{{ $group->country->name }}</h3>
                    <section id="user-infos">
                        <p class="infos-with-margin">{{ $group->description }}</p>
                        <p class="infos-with-margin subgroups"><a href="{{ url('/group/'.$group->id.'/subgroups') }}">{{ count($subgroups) }} Subgroups</a></p>
                        <p class="infos-with-margin members"><a href="{{ url('/group/'.$group->id.'/members') }}">{{ count($members) }} Members</a></p>
                    </section>
                </section>
                <section id="profile-buttons-area">
                        @if(Auth::user()->isAdmin())
                        <a class="button" href="{{ url('/group/'.$group->id.'/edit') }}"> Edit </a>
                        @endif
                        @if (Auth::check() && Auth::user()->isMember($group->id))
                        <button class="leave-group button" data-id="{{$group->id}}"> Leave </button>
                        @else
                        <button class="join-group" data-id="{{$group->id}}"> Join </button>
                        @endif
                        
                </section>
                
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

