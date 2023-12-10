<div class="btn-group dropend">
    @if($group->subgroup_id == null)
    <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}} btn-{{$group->id}}-{{$user->id}}" data-bs-toggle="modal" data-bs-target="#subgroups-{{$group->id}}-{{$user->id}}">
    {{$group->country->name}}
    </button>
    @else
    <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}} btn-{{$group->id}}-{{$user->id}}">
    {{$group->country->name}}
    </button>
    @endif
  <button type="button" class="btn {{$user->isOwner($group->id) ? 'btn-info' : ($user->isMember($group->id) ? 'btn-light' : ($user->isBannedFrom($group->id) ? 'btn-dark' : 'btn-secondary'))}} dropdown-toggle dropdown-toggle-split btn-{{$group->id}}-{{$user->id}}" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="visually-hidden">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item group-owner {{$user->isOwner($group->id) ? 'active' : ''}}" href="#" group-id="{{$group->id}}" user-id="{{$user->id}}">Owner</a></li>
    <li><a class="dropdown-item group-member {{$user->isMember($group->id) && !$user->isOwner($group->id) ? 'active' : ''}}" href="#" group-id="{{$group->id}}" user-id="{{$user->id}}">Member</a></li>
    <li><a class="dropdown-item group-banned {{$user->isBannedFrom($group->id) ? 'active' : ''}}" href="#" group-id="{{$group->id}}" user-id="{{$user->id}}">Banned</a></li>
  </ul>
</div>