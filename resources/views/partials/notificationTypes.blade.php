@include('partials.topbar')

@section('notificationTypes')

<section id="notificationTypes">
    @yield('topbar')
    
    @if($followRequestUsers->count() > 0)
        @foreach($followRequestUsers as $followRequestUser)
            <section class="follow-request-container" id="follow-request-id-{{$followRequestUser->id}}">

                <a href="{{ url('/user/'.$followRequestUser->id) }}" class="profile-info">
                    <div id="profile-picture">
                        <img src="../man.jpg" alt="Profile Picture">
                    </div>
                    @if (Auth::check())
                        <h2 id="user-username">&#64;{{ $followRequestUser->username }} wants to follow you!</h2>
                    @endif
                </a>
                
                <div class="request-buttons">
                    <button class="accept-request" data-id="{{$followRequestUser->id}}"> Accept </button>
                    <button class="decline-request" data-id="{{$followRequestUser->id}}"> Decline </button>
                </div>

            </section>
        @endforeach
    @else
        <p>No follow requests.</p>
    @endif

@endsection
