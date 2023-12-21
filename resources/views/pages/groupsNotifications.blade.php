@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('content')
        @yield('bar')
        <section id="feed">
            @yield('topbar')
            <section class="notification-container">
                <section id="notifications">
                    <h2>Notifications</h2>
                    @if($notifications->count() > 0)
                        <ul class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                                <a href="{{url('/group/'.$notification->group->id)}}" >
                                    <li id="notification-list" class="list-group-item list-group-item-light">
                                        <div class="notification-info">
                                            @if($notification->senderUser != null)
                                                <p class="notification-sender">{{$notification->senderUser->name}}</p>
                                            @endif
                                            <p class="notification-text">
                                                
                                                @if($notification->notification_type == 'group_join')
                                                    joined your group 
                                                @elseif($notification->notification_type == 'group_leave')
                                                    leave your group 
                                                @elseif($notification->notification_type == 'group_ban')
                                                    was banned from your group
                                                @elseif($notification->notification_type == 'group_owner')
                                                    is a new owner of your group
                                                @endif
                                                {{$notification->notification_type}}
                                                {{$notification->group->country->name}}
                                            </p>
                                        </div>
                                    </li>
                                </a>
                        @endforeach
                        </ul>
                    @else
                        <p>No Notifications.</p>
                    @endif
                </section>
            </section>
        </section>
@endsection