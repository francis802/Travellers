@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('title')
    Edit Group | Travellers
@endsection

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="create-post">
                        <form class="create-post-form" action="{{ url('/group/'.$group->id.'/edit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h2>Edit Post</h2>
                        <div id="preview-container-group">
                                <div id="close-button" onclick="removeImage()" style="{{$group->banner_pic !== null ? 'block' : 'none'}}">&times;</div>
                                @if ($group->banner_pic !== null)
                                        <img id="image-preview" class="img-fluid" src="{{url($group->banner_pic)}}" alt="Previous Image">
                                @else
                                        <img id="image-preview" class="img-fluid" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                                @endif
                        </div>
                        <label class="btn btn-secondary" for="image" id="file-label">
                                @if ($group->banner_pic !== null)
                                        Change Photo
                                @else
                                        Select Photo
                                @endif
                                </label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                        <textarea id="post-text" name="text" rows="5" cols="50" maxlength="256" autofocus>{{ $group->description }}</textarea>
                        <input type="hidden" name="clicked_x" id="clicked_x" value="no">
                        <button class="btn btn-primary" type="submit">Upload Group</button>
                        </form>
                </section>
        </section>
@endsection
