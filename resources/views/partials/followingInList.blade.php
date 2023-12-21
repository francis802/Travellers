@include('partials.topbar')

@section('followingInList')

<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
    <section id="notifications">
        <h2 class="followers"> Following </h2>
    @if (count($following) > 0)
        @foreach($following as $following_user)
        <section class="ff-bar" id="user-bar-id-{{$following_user->id}}">
            <a href="{{ url('/user/'.$following_user->id) }}" class="ff-info">
                <div id="profile-picture">
                    @if ($following_user->profile_photo !== null)
                        <img class="img-notification img-user" src="{{ url($following_user->profile_photo) }}" alt="Profile Picture">
                    @else
                    <img class="img-notification img-user" src="{{url('man.jpg')}}" alt="Profile Picture">
                    @endif
                </div>
                @if (Auth::check())
                    <h2 class="ff-username">
                        @if ($following_user->is_deleted)
                            [Deleted User]
                        @else
                        &#64;{{ $following_user->username }}
                        @endif
                    </h2>
                @endif
            </a>
            
        </section>
        @endforeach
    @elseif (Auth::user()->id == $user->id)
        <h2> You have don't follow anyone. </h2>
    @else
        <h2> &#64{{$user->username}} doesn't follow anyone. </h2>
    @endif
</section>
</section>
</section>
@endsection
