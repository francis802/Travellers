@include('partials.topbar')

@section('user')
<section id="profile">
    @yield('topbar')
        <section id="user-presentation"> 
            <div id="profile-picture">
                <img src="../man.jpg" alt="Profile Picture">
            </div>
                <section id="profile-text">
                    <h3 id="user-name">{{$user->name }}</h3>
                    <h4 id="user-username">&#64;{{$user->username }} | {{$user->country }}</h4>
                    <section id="user-infos">
                        <p class="infos-with-margin">{{ count($posts) }} Groups</p>
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
                            <li class="post">
                                <section class="post-container">
                                    <div id="post-header">
                                        <a  id="post-author" href="{{ url('/user/'.$user->id) }}">{{ $user->name }}</a>
                                        @if($post->id == Auth::user()->id || Auth::user()->isAdmin())
                                            <a id="edit-post" href="">...</a>
                                        @endif
                                    </div>
                                    <div id="post-content">
                                        <p>{{ $post->text }}</p>
                                        
                                    </div>
                                    <div id="post-interaction">

                                    </div>
                                    
                                </section>
                            </li>
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

