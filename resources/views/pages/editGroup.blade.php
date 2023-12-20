@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    
        @yield('bar')
        <section id="feed">
                @yield('topbar')
                <section class="create-post">
                        <form class="create-post-form" action="{{ url('/group/'.$group->id.'/edit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section id="post-choose-photo">
                                <label for="image" id="file-label">
                                Select Photo
                                </label>
                                <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display: none" onchange="displayImage(this)">
                        </section>
                        <div id="preview-container">
                                <div id="close-button" onclick="removeImage()" style="{{$group->banner_pic !== null ? 'block' : 'none'}}">&times;</div>
                                @if ($group->banner_pic !== null)
                                <img id="image-preview" src="{{url($group->banner_pic)}}" alt="Previous Image">
                                @endif
                        </div>
                        <textarea id="post-text" name="text" rows="10" cols="30" maxlength="256" autofocus>{{ $group->description }}</textarea>
                        <button class="button" type="submit">Upload Group</button>
                        </form>
                </section>
        </section>
@endsection
