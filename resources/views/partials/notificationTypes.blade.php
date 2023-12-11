@include('partials.topbar')

@section('notificationTypes')

<section id="feed">
    @yield('topbar')

    <section id="buttons">
        <button id="notificationsButton" class="underline" onclick="changeView('notificationsButton', 'notifications')">Notifications</button>
        <button id="requestsButton" onclick="changeView('requestsButton', 'requests')">
            Requests
            <span class="badge bg-primary rounded-pill">{{$followRequestUsers->count()}}</span>
        </button>
    </section>
    
    <script>
        function changeView(buttonId, sectionId) {
            const buttons = document.querySelectorAll('#buttons button');
            buttons.forEach(button => {
                button.classList.remove('underline');
            });
            const selectedButton = document.getElementById(buttonId);
            selectedButton.classList.add('underline');

            document.getElementById('notifications').style.display = 'none';
            document.getElementById('requests').style.display = 'none';

            document.getElementById(sectionId).style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('requests').style.display = 'none';
        });
    </script>
    
        <section id="requests">
            <h2>Requests</h2>
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
        </section>
        


    <section id="notifications">
        <h2>Notifications</h2>
        @if($followNotifications->count() > 0)
            <ul class="list-group list-group-flush">
                @foreach($followNotifications as $followNotification)
                    <section class="follow-notification-container" id="follow-notification-id-{{$followNotification->id}}">
                        @if(!$followNotification->opened)
                            <li class="list-group-item list-group-item-primary">
                                <a href="" class="notification-info">
                                    <p>{{$followNotification->notification_type}}</p>
                                </a>
                            </li>
                        @else
                            <li class="list-group-item list-group-item-light">
                                <a href="" class="notification-info">
                                    <p>{{$followNotification->notification_type}}</p>
                                </a>
                            </li>
                        @endif
                    </section>
                @endforeach
                
            </ul>
        @else
            <p>No Notifications.</p>
        @endif
    </section>







</section>
@endsection
