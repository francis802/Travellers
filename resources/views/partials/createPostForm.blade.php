@section('createPostForm')
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
        <label>
            Select Photo: <input type="file" id="image" name="image" accept="image/png, image/jpeg">
        </label>
    </section>
    <textarea id="post-text" placeholder="Tell the world where have you been..." id="newpost-content" name="text" rows="10" cols="30" maxlength="256" autofocus></textarea>
    <button class="button" type="submit">Create Post</button>
</form>
</section>
@endsection