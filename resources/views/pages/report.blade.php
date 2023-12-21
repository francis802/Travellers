@extends('layouts.app')
@include('partials.adminbar')
@include('partials.topbar')

@section('title')
    Report | Travellers
@endsection

@section('content')
    @yield('adminbar')
    <section id="feed">
        @yield('topbar')
        <form action="/report/user/{{$infractor->id}}" method="POST">
            @csrf
            <div class="card">
            <h5 class="card-header">
            <a href="{{ url('/user/'. $infractor->id) }}" class="profile-info">
                    <div id="profile-picture-sml">
                        @if ($infractor->profile_photo !== null)
                            <img src="{{ url($infractor->profile_photo) }}" alt="Profile Picture">
                        @else
                        <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                        @endif
                    </div>
                    <h2 id="user-username">&#64;{{ $infractor->username }}</h2>
                </a>
            </h5>
            <div class="card-body">
                <h5 class="card-title">Report User</h5>
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
                <input type="hidden" id="infractor_id" name="infractor_id" value="{{$infractor->id}}">
                <br/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </form>

    </section>
@endsection