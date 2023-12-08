@include('partials.topbar')

@section('user')
<section id="feed">
    @yield('topbar')
        <section id="user-presentation"> 
            <div id="profile-picture">
                @if ($user->profile_photo !== null)
                    <img src="{{ url($user->profile_photo) }}">
                @else
                    <img src="../man.jpg" alt="Profile Picture">
                @endif
            </div>
                <section id="profile-text">
                    <h3 id="user-name">{{$user->name }}</h3>
                    <h4 id="user-username">&#64;{{$user->username }} | {{$user->country }}</h4>
                    <section id="user-infos">
                        <p class="infos-with-margin"><a href="{{ url('/user/'.$user->id.'/groups') }}">{{ count($groups) }} Groups</a></p>
                        <p class="infos-with-margin">{{ count($followers) }} Followers</p>
                        <p>{{ count($following) }} Following</p>
                    </section>
                </section>
                <section id="profile-buttons-area">
                    @if(Auth::user()->isAdmin() || Auth::user()->id == $user->id)
                        <a class="button" href="{{ url('/user/edit') }}"> Edit </a>
                    @endif
                    @if (Auth::check() && Auth::user()->id == $user->id)
                        <a class="button" href="{{ url('/logout') }}"> Logout </a>
                    @else
                        <a class="button" href=""> Follow </a>
                    @endif
                </section>
        </section>
      
        
        <section id="user-posts">
            @if((Auth::check() && Auth::user()->id == $user->id) || (!$user->profile_private) || (Auth::check() && Auth::user()->follows($user->id) || Auth::user()->isAdmin()))
                @if(count($posts) > 0)
                    <ul id="user-post-list">
                        @foreach($posts as $post)
                            @include('partials.post', ['post' => $post])
                        @endforeach
                    </ul>
                @else
                    <p>This user has no posts.</p>
                @endif
            @else
                <p>This profile is private.</p>
            @endif
        </section>
</section>
@endsection

