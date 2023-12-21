@include('partials.topbar')

@section('followerInList')

<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
    <section id="notifications">
        <h2 class="followers"> Followers </h2>
        @if (count($followers) > 0)
            @foreach($followers as $follower)
            <section class="ff-bar" id="user-bar-id-{{$follower->id}}">
                    <a href="{{ url('/user/'.$follower->id) }}" class="ff-info">
                        <div id="profile-picture">
                            @if ($follower->profile_photo !== null)
                                <img class="img-notification img-user" src="{{ url($follower->profile_photo) }}" alt="Profile Picture">
                            @else
                            <img class="img-notification img-user" src="{{url('man.jpg')}}" alt="Profile Picture">
                            @endif
                        </div>
                        @if (Auth::check())
                            <h2 class="ff-username">
                                @if ($follower->is_deleted)
                                    [Deleted User]
                                @else
                                &#64;{{ $follower->username }}
                                @endif
                            </h2>
                        @endif
                    </a>
                    @if (Auth::user()->id == $user->id)
                        <button class="remove-follower btn btn-primary" data-id="{{$follower->id}}"> Remove </button>
                    @endif
                </section>
                @endforeach
            @elseif (Auth::user()->id == $user->id)
                <h2> You have no followers. </h2>
            @else
                <h2> &#64{{$user->username}} has no followers. </h2>
            @endif
        </section>
    </section>
</section>
@endsection
