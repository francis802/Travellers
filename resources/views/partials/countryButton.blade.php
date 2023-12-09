<div class="btn-group">
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#subgroups-{{$group->id}}">
    {{$group->country->name}}
    </button>
  <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="visually-hidden">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Owner</a></li>
    <li><a class="dropdown-item" href="#">Member</a></li>
    <li><a class="dropdown-item" href="#">Banned</a></li>
  </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="subgroups-{{$group->id}}" tabindex="-1" aria-labelledby="subgroups-{{$group->id}}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Groups</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach($group->subgroups()->get() as $subgroup)
            @include('partials.subgroupButton', ['subgroup' => $subgroup])
        @endforeach
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#exampleModal" data-bs-toggle="modal">Back to first</button>
      </div>
    </div>
  </div>
</div>