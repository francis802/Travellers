@section('createPostForm')
<form action="{{ url('post/create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <p>Select image to upload:</p>
    <input type="file" name="fileToUpload" accept="image/png,image/jpeg" id="fileToUpload">
    <p>Write a description:</p>
    <input type="text" name="description" id="description">
    <input type="submit" value="Upload Post" name="submit">
</form>
@endsection