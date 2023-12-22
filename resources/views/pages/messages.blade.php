@extends('layouts.app')

@include('partials.bar')
@include('partials.topbar')

@section('title')
    Messages | Travellers
@endsection

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <ul class="list-group list-group-flush">
                @foreach ($messengers as $userId => $userMessages)
                <a class="link-notification" href="{{url('/messages/user/'.$userId)}}" >
                    <li id="notification-list" class="list-group-item list-group-item-light">
                        <div class="notification-info">
                            <img class="img-notification img-user" src="{{ url($users->find($userId)->profile_photo) }}">
                            <p class="notification-text">{{$users->find($userId)->username}}
                            {{$userMessages[0]->content}}
                            </p>
                        </div>
                        {{$userMessages[0]->time->diffForHumans()}}
                    </li>
                </a>
                @endforeach
                </ul>

        </section>
   
@endsection