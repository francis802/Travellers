<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#user-{{$user->id}}">
  Reports on User
</button>

<!-- Modal -->
<div class="modal fade" id="user-{{$user->id}}" tabindex="-1" aria-labelledby="appealLabel-{{$user->id}}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="appealLabel-{{$user->id}}">Reports</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($user->reportsOnUser()->count() === 0)
            <p class="text-center">No previous reports on user</p>
        @else
        <p>Reports on user: <strong>{{$user->reportsOnUser()->count()}}</strong></p>
        @endif
        @foreach ($user->reportsOnUser()->get() as $report)
            @if ($report->infractor_id === $user->id)
                <div class="card mb-3" id="report-{{$report->id}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$report->title}}</h5>
                        <p class="card-text">{{$report->description}}</p>
                        @if ($report->ban_infractor === true)
                        <div class="choice-container">
                            Outcome: &nbsp;
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-ban"></i>
                                Banned
                            </button>
                        </div>
                        @elseif ($report->ban_infractor === false)
                        <div class="choice-container">
                            Outcome: &nbsp;
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-check"></i>
                                Not Banned
                            </button>
                        </div>
                        @endif
                        <p class="card-text"><small class="text-body-secondary">{{$report->date->diffForHumans()}}</small></p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    </div>
  </div>
</div>