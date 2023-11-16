@section('bar')
    <section id="side-bar">
        <ul id="upper-sidebar">
            @if (Auth::check())
            <li>
                    <a href="{{url('/user')}}" class="side-bar-link">Profile</a>        
            </li>
            @endif
            <li><a href="#" class="side-bar-link">Feed</a></li>
            <li><a href="#" class="side-bar-link">Notifications</a></li>
            <li><a href="#" class="side-bar-link">Help</a></li>
            <li><a href="#" class="side-bar-link">About Us</a></li>
            <li><a href="#" class="side-bar-link">Main Features</a></li>
            <li><a href="#" class="side-bar-link">Terms of Use and Privacy Policy</a></li>
        </ul>
        <ul id="lower-sidebar">
            
            <li><a href="#" class="side-bar-link" id="last-link">Create</a></li>
            <li><p class="rights-text">&copy; Travellers. All right reserved</p></li>
        </ul>
    </section>
@endsection