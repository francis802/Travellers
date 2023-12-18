@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    @yield('bar')
    <section id="feed">
    @yield('topbar')
    <div class="card text-center">
    <div class="card-header">
        Help Specifics
    </div>
    <div class="card-body">
        <h5 class="card-title">{{$help->title}}</h5>
        <p class="card-text">{{$help->description}}</p>
    </div>
    <div class="card-footer text-body-secondary">
        {{$help->humanDate()}}
    </div>
    </div>
    <div class="card answer">
    <div class="card-body">
        @if($help->answer == null && Auth::user()->isAdmin())
            <h5 class="card-title">Answer the help request down below:</h5>
            <form action="{{url('/help/'.$help->id.'/answer')}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" id="answer" name="answer" rows="3" placeholder="Thank you for contacting..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Answer</button>
            </form>
        @elseif($help->answer == null)
            <div class="center-text">
                <p class="card-text">
                    <i class="fa-solid fa-stopwatch"></i>
                    Your help request is still being reviewed. Thank you for your patience!
                </p>
            </div>
        @else
            <div class="center-text">
                <h5 class="card-title">Answer</h5>
                <p class="card-text">{{$help->answer}}</p>
            </div>
        @endif
    </div>
</div>

    </section>
    
@endsection
