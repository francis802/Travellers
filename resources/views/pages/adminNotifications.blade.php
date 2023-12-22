@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')

@section('title')
    Admin Notifications | Travellers
@endsection

@section('content')
        @yield('adminbar')

        <section id="feed">
                @yield('topbar')

                <section class="notifications-container" >
                        <section id="notifications">
                                <h2>Notifications</h2>
                                <ul class="list-group list-group-flush">
                                        @foreach($allnotifications as $notification)
                                                @if ($notification instanceof \App\Models\AppealNotification)
                                                <a class="link-notification" href="{{url('/admin/unban-requests')}}">
                                                        <li id="notification-list" class="list-group-item list-group-item-light">
                                                                <div class="notification-info">
                                                                        @if($notification->senderUser->profile_photo == null)
                                                                        <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                                                                        @else
                                                                        <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                                                        @endif
                                                                        
                                                                        <p class="notification-text">{{$notification->senderUser->username}} wants be unban</p>
                                                                </div>
                                                                <div class="request-buttons">
                                                                        {{$notification->time->diffForHumans()}}
                                                                </div>
                                                        </li>
                                                </a>
                                                @elseif ($notification instanceof \App\Models\HelpNotification)
                                                <a class="link-notification" href="{{url('/admin/helps')}}">
                                                        <li id="notification-list" class="list-group-item list-group-item-light">
                                                                <div class="notification-info">
                                                                        @if($notification->senderUser->profile_photo == null)
                                                                        <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                                                                        @else
                                                                        <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                                                        @endif
                                                                        <p class="notification-text">{{$notification->senderUser->username}} send a help request</p>
                                                                </div>
                                                                <div class="request-buttons">
                                                                        {{$notification->time->diffForHumans()}}
                                                                </div> 
                                                        </li>
                                                </a>
                                                @elseif ($notification instanceof \App\Models\ReportNotification)
                                                <a class="link-notification" href="{{url('/admin/reports')}}">
                                                        <li id="notification-list" class="list-group-item list-group-item-light">
                                                                <div class="notification-info">
                                                                        @if($notification->senderUser->profile_photo == null)
                                                                        <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                                                                        @else
                                                                        <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                                                        @endif
                                                                        <p class="notification-text">{{$notification->senderUser->username}} send a report</p>
                                                                </div>
                                                                <div class="request-buttons">
                                                                        {{$notification->time->diffForHumans()}}
                                                                </div> 
                                                        </li>
                                                </a>
                                                @elseif ($notification instanceof \App\Models\GroupCreationNotification)
                                                <a class="link-notification" href="{{url('/admin/groups')}}">
                                                        <li id="notification-list" class="list-group-item list-group-item-light">
                                                                <div class="notification-info">
                                                                @if($notification->senderUser->profile_photo == null)
                                                                        <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                                                                        @else
                                                                        <img class="img-notification img-user" src="{{ url($notification->senderUser->profile_photo) }}">
                                                                        @endif
                                                                        <p class="notification-text">{{$notification->senderUser->username}} propose a group</p>
                                                                </div>
                                                                <div class="request-buttons">
                                                                        {{$notification->time->diffForHumans()}}
                                                                </div> 
                                                        </li>
                                                </a>
                                                @endif

                                        @endforeach
                                </ul>
                        </section>
                </section>
       </section>
@endsection