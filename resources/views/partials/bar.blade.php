@section('bar')
        <nav class="menu-lateral">
            <ul class="ul-navbar">
                <li class="menu-item">
                    <a class="bar-link" href="{{url('/home/')}}">
                        <span class="icon"><i class="bi bi-house"></i></span>
                        <span class="txt-link">Home</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/user/'.Auth::user()->id) }}">
                        <span class="icon"><i class="bi bi-person"></i></span>
                        <span class="txt-link">Profile</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{url('/notifications/')}}">
                        @if(Auth::user()->unseenNotifications() > 0)
                            <span id="notification-count" class="badge bg-primary rounded-pill">{{Auth::user()->unseenNotifications()}}</span>
                        @endif
                        <span class="icon"><i class="bi bi-bell"></i></span>
                        <span class="txt-link">Notifications</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="bar-link" href="{{ url('/messages') }}">
                        <span class="icon"><i class="bi bi-messenger"></i></span>
                        <span class="txt-link">Messages</span>
                    </a>
                </li>
                <li class="menu-item">
                    <div id="last-link" class="bar-link btn-group dropend">
                        <span class="icon"><i class="bi bi-three-dots"></i></span>
                        <button type="button" class="txt-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            More
                        </button>
                        <ul class="dropdown-menu">
                            <li ><a href="{{url('/helps/')}}" class="dropdown-item" >Help</a></li>
                            <li><a href="{{url('/about')}}" class="dropdown-item">About Us</a></li>
                            <li><a href="{{url('/faqs/')}}" class="dropdown-item">FAQ</a></li>
                            <li><a href="{{url('/terms')}}" class="dropdown-item">Terms of Use and Privacy Policy</a></li>
                        </ul>
                    </div>
                </li>
                @if(Auth::check() && Auth::user()->isGroupOwner())
                    <li class="menu-item">
                        <a class="bar-link" href="{{ url('/user/'.Auth::user()->id .'/ownedGroups')}}">
                            @if(Auth::user()->unseenGroupNotifications() > 0)
                                <span id="notification-count" class="badge bg-primary rounded-pill">{{Auth::user()->unseenGroupNotifications()}}</span>
                            @endif
                            <span class="icon"><i class="bi bi-collection"></i></span>
                            <span class="txt-link">My Groups</span>
                        </a>
                    </li>
                @endif
                @if(Auth::check() && Auth::user()->isAdmin())
                    <li class="menu-item">
                        <a class="bar-link" href="{{ url('/admin/')}}">
                            <span class="icon"><i class="bi bi-fingerprint"></i></span>
                            <span class="txt-link">Admin Console</span>
                        </a>
                    </li>
                @endif
                <li class="menu-item">
                    <div id="last-link" class="bar-link btn-group dropend">
                        <span class="icon"><i class="bi bi-patch-plus"></i></span>
                        <button type="button" class="txt-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Create
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/post/create/')}}" class="dropdown-item" id="last-link">New Post</a></li>
                            <li><a href="{{ url('/group/create/')}}" class="dropdown-item" id="last-link">New Group</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
@endsection