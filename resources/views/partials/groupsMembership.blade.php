<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Check Groups
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Groups</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach($groups as $group)
            @if($group->subgroup_id == null)
                @include('partials.countryButton', ['group' => $group])
                @foreach($group->subgroups()->get() as $subgroup)
                    @include('partials.countryButton', ['group' => $subgroup])
                @endforeach
            @endif
        @endforeach
      </div>
    </div>
  </div>
</div>