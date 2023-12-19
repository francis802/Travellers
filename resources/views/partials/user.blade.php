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
            @if ($user->is_deleted)
                <h4 id="user-username">[Deleted User] | Country Unkown</h4>
            @else
                <h4 id="user-username">&#64;{{$user->username }} | {{$user->country->name}}</h4>
            @endif
            <section id="user-infos">
                <p class="infos-with-margin groups"><a href="{{ url('/user/'.$user->id.'/groups') }}">{{ count($groups) }} Groups</a></p>
                <p class="infos-with-margin followers"><a href="{{ url('/user/'.$user->id.'/followers') }}"> {{ count($followers) }} Followers</a></p>
                <p class="infos-with-margin following"><a href="{{ url('/user/'.$user->id.'/following') }}"> {{ count($following) }} Following</a></p>
            </section>
        </section>
        <section id="profile-buttons-area">
            
            
            <div id="edit-delete-post" class="btn-group dropstart">
            <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">...</button>
            <ul class="dropdown-menu">
                @if(Auth::user()->id == $user->id)
                            <li><a class="dropdown-item" href="{{ url('/user/edit') }}"> 
                                    <img src="../pen.png" alt="Edit Post">
                                    Edit
                                </a>
                            </li>
                        @else
                            @if($user->isBlocked(Auth::user()->id))
                                <li><a class="blocked block-user dropdown-item" href="#"  data-id="{{Auth::user()->id}} "data-user-id="{{$user->id}}" onclick="changeBlockStatus(event)">Unblock</a></li>
                            @else
                                <li><a class="block-user dropdown-item" href="#"  data-id="{{Auth::user()->id}} "data-user-id="{{$user->id}}" onclick="changeBlockStatus(event)">Block</a></li>
                            @endif
                        @endif
            </ul>
        </div>
@if (Auth::check() && Auth::user()->id == $user->id)
            <a class="button" href="{{ url('/logout') }}"> Logout </a>
            @elseif (Auth::check() && Auth::user()->follows($user->id))
            <button class="unfollow-user button" data-id="{{$user->id}}"> Unfollow </button>
            @elseif (Auth::check() && Auth::user()->requestFollowing($user->id))
            <button class="unfollow-user button" data-id="{{$user->id}}"> Requested </button>
            @else
            <button class="request-follow button" data-id="{{$user->id}}"> Follow </button>
            @endif

        </section>
    </section>


    <section id="user-posts">
        @if((Auth::check() && Auth::user()->id == $user->id) || (!$user->profile_private) || (Auth::check() &&
        Auth::user()->follows($user->id) || Auth::user()->isAdmin()))
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
