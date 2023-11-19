@section('user')

<section id="profile">
    
        <section id="user-presentation"> 
            <div id="profile-picture">
                <img src="../man.jpg" alt="Profile Picture">
            </div>
                <section id="profile-text">
                    <h3 id="user-name">{{$user->name }}</h3>
                    <h4 id="user-username">&#64;{{$user->username }} | {{$user->country }}</h4>
                    <section id="user-infos">
                        <p class="infos-with-margin">{{ count($user->getFollowers()->get()) }} Groups</p>
                        <p class="infos-with-margin">{{ count($user->getFollowers()->get()) }} Followers</p>
                        <p>{{ count($user->getFollowing()->get()) }} Following</p>
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
                <p>Posts comming soon...</p>
            @else
                <p>This profile is private.</p>
            @endif
        </section>
    
</section>
@endsection