@section('bar')
    <nav id="side-bar">
        <ul id="upper-sidebar">
            @if (Auth::check())
                <li>
                    <a href="{{ url('/user/'.Auth::user()->id) }}" class="side-bar-link">Profile</a>       
                </li>
            @endif
            <li><a href="{{url('/home/')}}" class="side-bar-link">Feed</a></li>
            <li>
                <a href="{{url('/notifications/')}}" class="side-bar-link">
                    Notifications 
                    @if(Auth::user()->unseenNotifications() > 0)
                        <span id="notification-count" class="badge bg-primary rounded-pill">{{Auth::user()->unseenNotifications()}}</span>
                    @endif
                </a>
            </li>
            <li><a href="#" class="side-bar-link">Help</a></li>
            <li><a href="#" class="side-bar-link">About Us</a></li>
            <li><a href="#" class="side-bar-link">Main Features</a></li>
            <li><a href="#" class="side-bar-link">Terms of Use and Privacy Policy</a></li>
        </ul>
        <ul id="lower-sidebar">
            <li><a href="{{ url('/post/create/')}}" class="side-bar-link" id="last-link">Create Post</a></li>
            <li><a href="{{ url('/group/create/')}}" class="side-bar-link" id="last-link">Create Group</a></li>
            @if(Auth::check() && Auth::user()->isAdmin())
                <li><a href="{{ url('/admin/')}}" class="side-bar-link" id="last-link">Admin Console</a></li>
            @endif
            <li><p class="rights-text">&copy; Travellers. All right reserved</p></li>
        </ul>
</nav>
@endsection