@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('content')
        @yield('bar')
        <section id="feed">
            @yield('topbar')
            <section class="create-post">
                        <form class="create-post-form" action="{{ url('/post/'.$post->id.'/edit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="preview-container-post">
                                <div id="close-button" onclick="removeImage()" style="{{$post->media !== null ? 'block' : 'none'}}">&times;</div>
                                @if ($post->media !== null)
                                <img id="image-preview" src="{{url($post->media)}}" alt="Previous Image">
                                @else
                                <img id="image-preview" src="{{asset('image-placeholder.jpg')}}" alt="Previous Image">
                                @endif
                        </div>
                        <label for="image" id="file-label">
                                @if ($post->media !== null)
                                Change Photo
                                @else
                                Select Photo
                                @endif
                                </label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                        <textarea id="post-text" name="text" rows="10" cols="30" maxlength="256" autofocus>{{ $post->text }}</textarea>
                        <input type="hidden" name="clicked_x" id="clicked_x" value="no">
                        <button class="button" type="submit">Upload Post</button>
                        </form>
                </section>
        </section>
@endsection