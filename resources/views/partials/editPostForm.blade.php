@section('editPostForm')
<section class="create-post">
<form class="create-post-form" action="{{ url('/post/'.$post->id.'/edit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <section id="post-choose-photo">
    <label>
        Select Photo: <input type="file" id="image" name="image" accept="image/png, image/jpeg">
    </label>
    </section>
    <textarea id="post-text" name="text" rows="10" cols="30" maxlength="256" autofocus>{{$post->text}}</textarea>
    <button class="button" type="submit">Upload Post</button>
</form>
</section>
@endsection