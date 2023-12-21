@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="notifications-container">
                        <form method="post" action="{{ url('help/create/') }}" enctype="multipart/form-data">
                                @csrf
                                <h2>Help</h2>
                                <div class="mb-3">
                                        <label for="title" class="form-label">Question</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" rows="5" cols="50" name="description" id="description" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                </section>
        </section>
@endsection
