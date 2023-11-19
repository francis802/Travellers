@section('editPostForm')
<form action="{{ url('/post/'.$post->id.'/edit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label>
        Select Photo: <input type="file" id="image" name="image" accept="image/png, image/jpeg">
    </label>
    <textarea id="newpost-content" name="text" rows="10" cols="30" maxlength="256" autofocus>{{$post->text}}</textarea>
    <input type="submit" value="Upload Post" name="submit">
</form>
@endsection