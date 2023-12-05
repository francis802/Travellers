@section('createGroupForm')
<section class="create-post">
<form class="create-post-form" action="{{ url('group/create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <section id="post-choose-photo">
    <label>
        Select a banner photo: <input type="file" id="image" name="image" accept="image/png, image/jpeg">
    </label>
    </section>
    <textarea id="post-text" placeholder="Description" id="newpost-content" name="text" rows="10" cols="30" maxlength="256" autofocus></textarea>
    <button class="button" type="submit">Propose Group</button>
</form>
</section>
@endsection