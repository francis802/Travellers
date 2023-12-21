@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="create-post">
                        <form class="create-post-form" action="{{ url('group/create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section id="post-choose-photo">
                                <div id="preview-container-group">
                                        <div id="close-button" onclick="removeImage()" style="display: none">&times;</div>
                                        <img id="image-preview" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                                </div>
                                <label for="image" id="file-label">
                                        Select Photo
                                </label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                        </section>
                        <input type="hidden" name="clicked_x" id="clicked_x" value="no">
                        <input type="text" id="post-title" placeholder="Group Name" name="country_title" maxlength="64" autofocus>
                        <select name="group_id" id="group_id" required>
                                @foreach ($parents as $group)
                                <option value="{{ $group->id }}">{{ $group->country->name }}</option>
                                @endforeach
                        </select>
                        <textarea id="post-text" placeholder="Description" id="newpost-content" name="text" rows="10" cols="30" maxlength="256" autofocus required></textarea>
                        <button class="button" type="submit">Propose Group</button>
                        </form>
                </section>
        </section>
   
@endsection