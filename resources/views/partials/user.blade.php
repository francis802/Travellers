@include('partials.topbar')

@section('user')
<section id="profile">
    @yield('topbar')
        <section id="user-presentation"> 
            <div id="profile-picture">
                <img src="../man.jpg" alt="Profile Picture">
            </div>
            <section id="profile-text">
                <h3 id="user-username">&#64;{{$user->username }}</h3>
            </section>
            <section id="profile-buttons-area">
            @if (Auth::check() && Auth::user()->id == $user->id)
                <a class="button" href="{{ url('/user/edit') }}"> Edit </a>
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
            @else
                <a class="button" href=""> Follow </a>
            @endif
            </section>
            <section id="user-infos">
                <p>{{ count($user->getFollowers()->get()) }} Followers</p>
                <p>{{ count($user->getFollowing()->get()) }} Following</p>
            </section>
        </section>

        <section id="user-posts">
            @if((Auth::check() && Auth::user()->id == $user->id) || (!$user->profile_private) || (Auth::check() && Auth::user()->follows($user->id)))
                <p>Posts comming soon...</p>
            @else
                <p>This profile is private.</p>
            @endif
        </section>
    
</section>
@endsection