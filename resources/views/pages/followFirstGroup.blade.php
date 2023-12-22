@extends('layouts.app')
@include('partials.topbar')
@include('partials.bar')

@section('title')
    First Steps | Travellers
@endsection

@section('content')
    @yield('bar')
    <section id="feed">
        @yield('topbar')
        <section class="fst-grp-header">
            <h2 class="fst-grp">Join your first group</h2>
            <a href="{{ url('/home') }}" class="btn btn-primary">Skip</a>
        </section>
            <div id="groups-list"class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($groups as $group)
                        <a href="{{ url('/group/'.$group->id) }}">
                            <div class="col">
                                <div class="card">
                                <img src="{{ url($group->banner_pic) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $group->country->name }}</h5>
                                    <p class="card-text">{{ $group->description }}</p>
                                </div>
                                </div>
                            </div>
                        </a>
                @endforeach
            </div>
       
    </section>
@endsection