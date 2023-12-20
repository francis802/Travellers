@include('partials.topbar')

@section('notificationTypes')

<section id="feed">
    @yield('topbar')

    <section id="buttons">
        <button id="notificationsButton" class="underline" onclick="changeView('notificationsButton', 'notifications')">Notifications</button>
        <button id="requestsButton" onclick="changeView('requestsButton', 'requests')">
            Requests     
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
    
    <section class="notifications-container" >
        <section id="requests">
            <h2>Requests</h2>
            @if($followRequestUsers->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($followRequestUsers as $followRequestUser)
                        <li id="request-list" class="list-group-item list-group-item-light">
                            <section class="follow-request-container" id="follow-request-id-{{$followRequestUser->id}}">
                                <a href="{{ url('/user/'.$followRequestUser->id) }}" class="profile-info">
                                    <div class="notification-info">
                                        <img class="img-notification img-user" src="{{ url($followRequestUser->profile_photo) }}">
                                        <p class="notification-text">&#64;{{ $followRequestUser->username }} wants to follow you!</h2>
                                    </div>    
                                </a>
                                <div class="request-buttons">
                                    <button type="button" class="accept-request btn btn-primary" data-id="{{$followRequestUser->id}}">Accept</button>
                                    <button type="button" class="decline-request btn btn-primary" data-id="{{$followRequestUser->id}}">Decline</button>
                                </div>
                            </section>
                        </li>
                        
                    @endforeach
                
            @else
                <p>No follow requests.</p>
            @endif
        </section>

        <section id="notifications">
            <h2>Notifications</h2>
            @if($allnotifications->count() > 0)
                <ul class="list-group list-group-flush">
                @foreach($allnotifications as $notification)
                    @if ($notification instanceof \App\Models\PostNotification)
                        <a class="link-notification" href="{{url('/post/'.$notification->post->id)}}" >
                            <li id="notification-list" class="list-group-item list-group-item-light">
                                <div class="notification-info">
                                    <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                    <p class="notification-text">{{$notification->senderUser->username}}
                                    @if($notification->notification_type == 'new_like')
                                        liked your post
                                    @elseif($notification->notification_type == 'mention_description')
                                        mentioned you in a comment
                                    @endif
                                    </p>
                                </div>
                                @if ($notification->post->media !== null)
                                    <img class="img-notification" src="{{ url($notification->post->media) }}">
                                @endif
                            </li>
                        </a>
                            
                    @elseif ($notification instanceof \App\Models\CommentNotification)
                        <a class="link-notification" href="{{url('/post/'.$notification->comment->post->id)}}" >
                            <li id="notification-list" class="list-group-item list-group-item-light">
                                <div class="notification-info">
                                    <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                    <p class="notification-text">{{$notification->senderUser->username}}
                                    @if($notification->notification_type == 'mention_comment')
                                        mentioned you in a comment
                                    @elseif($notification->notification_type == 'liked_comment')
                                        liked your comment
                                    @else
                                        comment in you post
                                    @endif
                                    </p>
                                </div>
                                @if ($notification->comment->post->media !== null)
                                    <img class="img-notification" src="{{ url($notification->comment->post->media) }}">
                                @endif
                                
                            </li>
                        </a>

                    @elseif ($notification instanceof \App\Models\FollowNotification)
                        @if($notification->notification_type == 'follow_accept')
                            <a class="link-notification" href="{{url('/user/'.$notification->senderUser->id)}}">
                                <li id="notification-list" class="list-group-item list-group-item-light">
                                    <div class="notification-info">
                                        <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                        <p class="notification-text">{{$notification->senderUser->username}} accept you</p>
                                    </div>
                                </li>
                            </a>
                        @endif
                    @else
                        <p>Tipo de notificação não reconhecido</p>
                    @endif
                @endforeach
                </ul>
            @else
                <p>No Notifications.</p>
            @endif
        </section>
        
    </section>
</section>
@endsection
