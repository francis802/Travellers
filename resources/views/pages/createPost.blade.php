@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="create-post">
                <form class="create-post-form" action="{{ url('post/create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h2>Create Post</h2>
                <section id="post-choose-group">
                        <label>
                        Select Group: 
                        <select name="group_id" id="group_id">
                                @foreach ($usergroups as $group)
                                <option value="{{ $group->id }}">{{ $group->country->name }}</option>
                                @endforeach
                        </select>
                        </label>
                <section id="post-choose-photo">
                        <div id="preview-container-post">
                                <div id="close-button" onclick="removeImage()" style="display: none">&times;</div>
                                <img id="image-preview" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                        </div>
                        <label for="image" id="file-label">
                                Select Photo
                        </label>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                </section>
                <textarea id="post-text" placeholder="Tell the world where have you been..." id="newpost-content" name="text" rows="10" cols="30" maxlength="256" autofocus></textarea>
                <button class="button" type="submit">Create Post</button>
                </form>
                </section>
        </section>
@endsection