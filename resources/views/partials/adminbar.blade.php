@section('adminbar')
       <nav class="menu-lateral" logged-user="{{Auth::user()->id}}">
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
                    <a  class="bar-link" href="{{ url('/admin/notifications/')}}">
                        @if(Auth::user()->getAdmin->unseenNotifications() > 0)
                            <span id="notification-count" class="badge bg-primary rounded-pill admin-notifs">{{Auth::user()->getAdmin->unseenNotifications()}}</span>
                        @endif
                        <span class="icon"><i class="bi bi-bell"></i></span>
                        <span class="txt-link">Notifications</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/admin/users/')}}">
                        <span class="icon"><i class="bi bi-people"></i></span>
                        <span class="txt-link">Users</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/admin/groups/')}}">
                        <span class="icon"><i class="bi bi-collection"></i></span>
                        <span class="txt-link">Groups</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/admin/reports/')}}">
                        <span class="icon"><i class="bi bi-flag"></i></span>
                        <span class="txt-link">Reports</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/admin/helps/')}}">
                        <span class="icon"><i class="bi bi-patch-question"></i></span>
                        <span class="txt-link">Help Requests</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a  class="bar-link" href="{{ url('/admin/unban-requests/')}}">
                        <span class="icon"><i class="bi bi-ban"></i></span>
                        <span class="txt-link">Unban Requests</span>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <li class="menu-item">
                        <a class="bar-link" href="{{ url('/admin/')}}">
                            <span class="icon"><i class="bi bi-fingerprint"></i></i></span>
                            <span class="txt-link">Admin Console</span>
                        </a>
                    </li>
                @endif
                
            </ul>
        </nav>
@endsection