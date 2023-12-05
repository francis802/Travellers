@section('editGroupForm')
<section class="create-post">
<form class="create-post-form" action="{{ url('/group/'.$group->id.'/edit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <section id="post-choose-photo">
    <label>
        Select Photo: <input type="file" id="image" name="image" accept="image/png, image/jpeg">
    </label>
    </section>
    <textarea id="post-text" name="text" rows="10" cols="30" maxlength="256" autofocus>{{$group->description}}</textarea>
    <button class="button" type="submit">Upload Group</button>
</form>
</section>
@endsection