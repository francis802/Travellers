<div class="btn-group dropend">
    @if($group->subgroup_id == null)
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#subgroups-{{$group->id}}">
    {{$group->country->name}}
    </button>
    @else
    <button type="button" class="btn btn-secondary">
    {{$group->country->name}}
    </button>
    @endif
  <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="visually-hidden">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Owner</a></li>
    <li><a class="dropdown-item" href="#">Member</a></li>
    <li><a class="dropdown-item" href="#">Banned</a></li>
  </ul>
</div>