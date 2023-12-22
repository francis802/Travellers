@extends('layouts.app')

@include('partials.bar')
@include('partials.topbar')

@section('title')
    Create Post | Travellers
@endsection

@section('content')
        @yield('bar')
        <section id="feed">
                @yield('topbar')
        <section class="create-post">
                <form class="create-post-form" action="{{ url('post/create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h2>Create Post</h2>
                <section id="post-choose-group">
                        
                        <div id="preview-container-post">
                                <div id="close-button" onclick="removeImage()" style="display: none">&times;</div>
                                <img id="image-preview" class="img-fluid" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                        </div>
                        <label class="btn btn-secondary select-img" for="image" id="file-label">
                                Select Photo
                        </label>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">

                        <label for="group_id">
                        Select Group: 
                        </label>
                        <select class="form-select form-select-sm" name="group_id" id="group_id">
                                @foreach ($usergroups as $group)
                                <option value="{{ $group->id }}">{{ $group->country->name }}</option>
                                @endforeach
                        </select>
                </section>
              
                        
                
                <input type="hidden" name="clicked_x" id="clicked_x" value="no">
                <textarea id="post-text" placeholder="Tell the world where have you been..." id="newpost-content" name="text" rows="5" cols="50" maxlength="256" autofocus></textarea>
                <button class="btn btn-primary" type="submit">Create Post</button>
                </form>
                </section>
        </section>
@endsection