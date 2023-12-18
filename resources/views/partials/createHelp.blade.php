@section('createHelp')
<form method="post" action="{{ url('help/create/') }}" enctype="multipart/form-data">
  @csrf
<div class="mb-3">
  <label for="title" class="form-label">Title</label>
  <input type="text" class="form-control" id="title" name="title" required>
</div>
<div class="mb-3">
  <label for="description" class="form-label">Description</label>
  <textarea class="form-control" rows="3" name="description" id="description" required></textarea>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection