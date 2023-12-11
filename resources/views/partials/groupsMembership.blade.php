<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#allCountries-{{$user->id}}">
  Check Groups
</button>

<!-- Modal -->
<div class="modal fade" id="allCountries-{{$user->id}}" tabindex="-1" aria-labelledby="allCountriesLabel-{{$user->id}}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="allCountriesLabel-{{$user->id}}">All Countries</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach($groups as $group)
            @if($group->subgroup_id == null)
                @include('partials.countryButton', ['group' => $group, 'user' => $user])
            @endif
        @endforeach
        <br><br><br>
      </div>
    </div>
  </div>
</div>

<!-- Subgroup Modal -->
@foreach($groups as $group)
<div class="modal fade" id="subgroups-{{$group->id}}-{{$user->id}}" tabindex="-1" aria-labelledby="subgroups-{{$group->id}}-{{$user->id}}-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="subgroups-{{$group->id}}-{{$user->id}}-label">{{$group->country->name}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach($group->subgroups()->get() as $subgroup)
            @include('partials.countryButton', ['group' => $subgroup, 'user' => $user])
        @endforeach
        <br><br><br>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#allCountries-{{$user->id}}" data-bs-toggle="modal">Back to first</button>
      </div>
    </div>
  </div>
</div>
@endforeach
