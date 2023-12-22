@extends('layouts.app')

@include('partials.bar')
@include('partials.topbar')

@section('title')
    Create Group | Travellers
@endsection

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="create-post">
                        <form class="create-post-form" action="{{ url('group/create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h2>Create Group</h2>
                        <section id="post-choose-group">
                                <div id="preview-container-post">
                                        <div id="close-button" onclick="removeImage()" style="display: none">&times;</div>
                                        <img id="image-preview" class="img-fluid" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                                </div>
                                <label class="btn btn-secondary select-img" for="image" id="file-label">
                                        Select Photo
                                </label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                                
                                <input class="choose-group-name" type="text" id="post-title" placeholder="Group Name" name="country_title" maxlength="64" autofocus>
                                <select class="form-select form-select-sm" name="group_id" id="group_id" required>
                                        @foreach ($parents as $group)
                                        <option value="{{ $group->id }}">{{ $group->country->name }}</option>
                                        @endforeach
                                </select>
                        </section>
                        <input type="hidden" name="clicked_x" id="clicked_x" value="no">
                        
                        <textarea id="post-text" placeholder="Description" id="newpost-content" name="text" rows="5" cols="50" maxlength="256" autofocus required></textarea>
                        <button class="btn btn-primary" type="submit">Propose Group</button>
                        </form>
                </section>
        </section>
   
@endsection