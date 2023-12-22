@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('title')
    Group Notifications | Travellers
@endsection

@section('content')
        @yield('bar')
        <section id="feed">
            @yield('topbar')
            <section class="notifications-container">
                <section id="notifications">
                    <h2>Notifications</h2>
                    @if($notifications->count() > 0)
                        <ul class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                                <a class="link-notification" href="{{url('/group/'.$notification->group->id)}}" >
                                    <li id="notification-list" class="list-group-item list-group-item-light">
                                        <div class="notification-info">
                                            @if($notification->senderUser != null)
                                                @if($notification->senderUser->profile_photo == null)
                                                <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                                                @else
                                                <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                                @endif
                                            @endif
                                            <p class="notification-text">
                                                @if($notification->senderUser != null)
                                                    {{$notification->senderUser->username}}
                                                @endif
                                                @if($notification->notification_type == 'group_join')
                                                    joined your group 
                                                @elseif($notification->notification_type == 'group_leave')
                                                    leave your group 
                                                @elseif($notification->notification_type == 'group_ban')
                                                    was banned from your group
                                                @elseif($notification->notification_type == 'group_owner')
                                                    New owner on group
                                                @endif
                                                
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