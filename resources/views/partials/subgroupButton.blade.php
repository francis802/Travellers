<div class="btn-group">
    <button type="button" class="btn btn-secondary" data-bs-target="#exampleModal1">
    {{$subgroup->country->name}}
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