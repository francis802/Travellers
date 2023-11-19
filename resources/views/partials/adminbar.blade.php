@section('adminbar')
    <section id="side-bar">
        <ul id="upper-sidebar">
            @if (Auth::check())
            <li>
                <a class="side-bar-link name-link" id="user={{Auth::user()->id}}" href="{{ url('/user/'.Auth::user()->id) }}">{{ Auth::user()->name }}</a>       
            </li>
            @endif
            <li><a href="{{ url('/home/')}}" class="side-bar-link">Feed</a></li>
            <li><a href="#" class="side-bar-link">Notifications</a></li>
            <li><a href="#" class="side-bar-link">Users</a></li>
            <li><a href="#" class="side-bar-link">Groups</a></li>
        </ul>
        <ul id="lower-sidebar">
            @if(Auth::check() && Auth::user()->isAdmin())
                <li><a href="{{ url('/admin/')}}" class="side-bar-link" id="last-link">Admin Console</a></li>
            @endif
            <li><a href="{{ url('/post/create/')}}" class="side-bar-link" id="last-link">Create Post</a></li>
            <li><p class="rights-text">&copy; Travellers. All right reserved</p></li>
        </ul>
    </section>
@endsection