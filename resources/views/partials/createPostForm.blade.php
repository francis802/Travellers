@section('createPostForm')
<form action="{{ url('post/create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label>
        Select Photo: <input type="file" id="image" name="image">
    </label>
    <textarea placeholder="Tell the world where have you been..." id="newpost-content" name="content" rows="10" cols="30" maxlength="256" autofocus></textarea>
    <input type="submit" value="Upload Post" name="submit">
</form>
@endsection