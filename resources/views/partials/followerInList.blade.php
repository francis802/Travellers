@include('partials.topbar')

@section('followerInList')

<section id="feed">
    @yield('topbar')
    @if (count($followers) > 0)
        <h2 class="followers"> Followers ({{count($followers)}}) </h2>
        @foreach($followers as $follower)
        <section class="user-bar" id="user-bar-id-{{$follower->id}}">
            <a href="{{ url('/user/'.$follower->id) }}" class="profile-info">
                <div id="profile-picture">
                    @if ($follower->profile_photo !== null)
                        <img src="{{ url($follower->profile_photo) }}" alt="Profile Picture">
                    @else
                    <img src="{{url('man.jpg')}}" alt="Profile Picture">
                    @endif
                </div>
                @if (Auth::check())
                    <h2 id="user-username">
                        @if ($follower->is_deleted)
                            [Deleted User]
                        @else
                        &#64;{{ $follower->username }}
                        @endif
                    </h2>
                @endif
            </a>
            @if (Auth::user()->id == $user->id)
                <button class="remove-follower" data-id="{{$follower->id}}"> Remove </button>
            @endif
        </section>
        @endforeach
    @elseif (Auth::user()->id == $user->id)
        <h2> You have no followers. </h2>
    @else
        <h2> &#64{{$user->username}} has no followers. </h2>
    @endif
</section>

@endsection