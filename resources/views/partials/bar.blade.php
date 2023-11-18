@section('bar')
    <section id="side-bar">
        <ul id="upper-sidebar">
            @if (Auth::check())
            <li>
                <a id="user={{Auth::user()->id}}" href="{{ url('/user/'.Auth::user()->id) }}">{{ Auth::user()->name }}</a>       
            </li>
            @endif
            <li><a href="{{ url('/home/')}}" class="side-bar-link">Feed</a></li>
            <li><a href="#" class="side-bar-link">Notifications</a></li>
            <li><a href="#" class="side-bar-link">Help</a></li>
            <li><a href="#" class="side-bar-link">About Us</a></li>
            <li><a href="#" class="side-bar-link">Main Features</a></li>
            <li><a href="#" class="side-bar-link">Terms of Use and Privacy Policy</a></li>
        </ul>
        <ul id="lower-sidebar">
            <li><a href="{{ url('/post/create/')}}" class="side-bar-link" id="last-link">Create Post</a></li>
            <li><p class="rights-text">&copy; Travellers. All right reserved</p></li>
        </ul>
    </section>
@endsection