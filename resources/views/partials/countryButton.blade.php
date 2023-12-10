<div class="btn-group dropend">
    @if($group->subgroup_id == null)
    <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}}" data-bs-toggle="modal" data-bs-target="#subgroups-{{$group->id}}-{{$user->id}}">
    {{$group->country->name}}
    </button>
    @else
    <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}}">
    {{$group->country->name}}
    </button>
    @endif
  <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}} dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="visually-hidden">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item {{$user->isOwner($group->id) ? 'active' : ''}}" href="#">Owner</a></li>
    <li><a class="dropdown-item {{$user->isMember($group->id) && !$user->isOwner($group->id) ? 'active' : ''}}" href="#">Member</a></li>
    <li><a class="dropdown-item {{$user->isBannedFrom($group->id) ? 'active' : ''}}" href="#">Banned</a></li>
  </ul>
</div>