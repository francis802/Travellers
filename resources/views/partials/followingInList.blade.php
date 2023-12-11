@include('partials.topbar')

@section('followingInList')

<section id = "following-in-list">
    @yield('topbar')
    @if (count($following) > 0)
    <h2> Following ({{count($following)}}) </h2>
        @foreach($following as $following_user)
        <section id="user-bar">
            <a href="{{ url('/user/'.$following_user->id) }}" class="profile-info">
                <div id="profile-picture">
                    <img src="{{url('man.jpg')}}" alt="Profile Picture">
                </div>
                @if (Auth::check())
                    <h2 id="user-username">&#64;{{ $following_user->username }}</h2>
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

@endsection
