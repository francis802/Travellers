@extends('layouts.app')
@include('partials.topbar')
@section('title', 'Home')
@include('partials.bar')


@section('content')
    
        @yield('bar')
        <section id="feed">
            <section class="user-chat-info">
                <a class="msg-top-link" href="{{ url('/messages') }}"><i class="bi bi-caret-left"></i></a>
                <a class="msg-top-link" href="{{ url('/user/'.$user->id) }}">
                    <h3 class="msg-top-txt">{{$user->name}}</h3>
                    <p class="msg-top-txt">{{$user->username}}</p>
                </a>
            </section>

            <section class="message-view" logged-user="{{Auth::user()->id}}">
                @if(count($messages) !== 0)
                    @foreach($messages as $message)
                        @if($message->sender_id == Auth::user()->id)
                            <div class="card my-msg">
                                <div class="card-body">
                                    {{$message->content}}
                                </div>
                            </div>
                        @else
                            <div class="card other-msg">
                                <div class="card-body">
                                {{$message->content}}
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p>No messages yet</p>
                @endif
            </section>

            <section class="message-input">
                <form class="send-msg-form">
                    <textarea name="message" id="message" class="form-control" placeholder="Message..." ></textarea>
                    <button type="submit" to-user="{{$user->id}}" class="send-msg btn btn-primary"><i class="bi bi-send"></i></button>
                </form>
            </section>
    </section>
   
@endsection