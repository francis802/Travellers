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
                                @if($group->banner_pic)
                                <img id="image-preview" src="{{ url($group->banner_pic) }}" alt="Previous Image" width=300px>
                                @else
                                <img id="image-preview" style="display: none" alt="Previous Image">
                                @endif
                        </div>
                        <textarea id="post-text" name="text" rows="10" cols="30" maxlength="256" autofocus>{{$group->description}}</textarea>
                        <button class="button" type="submit">Upload Group</button>
                        </form>
                </section>

                <script>
                        function displayImage(input) {
                        var preview = document.getElementById('image-preview');
                        var label = document.getElementById('file-label');
                        var container = document.getElementById('preview-container');

                        var file = input.files[0];
                        
                        if (file) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                                label.innerText = 'Change Photo';
                                container.style.height = 'auto';
                                };
                                reader.readAsDataURL(file);
                        } else {
                                // No file selected
                                preview.style.display = 'none';
                                label.innerText = 'Select Photo';
                                container.style.height = '0';
                        }
                        }
                </script>

        </section>
   
@endsection