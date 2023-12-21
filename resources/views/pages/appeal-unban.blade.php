@extends('layouts.app')
@include('partials.topbar')

@section('title')
    Appeal Unban | Travellers
@endsection

@section('content')
    <section id="feed">
        @yield('topbar')

        <section class="unban-form mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">Appeal Unban Form</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('submit_unban_appeal') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit Appeal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
