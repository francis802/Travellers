<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#report-{{$report->id}}">
  View Details
</button>

<!-- Modal -->
<div class="modal fade" id="report-{{$report->id}}" tabindex="-1" aria-labelledby="reportLabel-{{$report->id}}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="reportLabel-{{$report->id}}">Report #{{$report->id}}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>{{$report->title}}</h4>
        <p>{{$report->description}}</p>
        @if ($report->ban_infractor === true)
        <div class="choice-container">
            <strong> <a href="{{ url('/user/'. $report->infractor->id) }}"> &#64;{{$report->infractor->username}}</a> &nbsp; has been banned. </strong>
        <div>
        @elseif ($report->ban_infractor === false)
        <div class="choice-container">
            <strong> <a href="{{ url('/user/'. $report->infractor->id) }}"> &#64;{{$report->infractor->username}}</a> &nbsp; has not been banned. </strong>
        <div>
        @elseif ($report->ban_infractor === null)
        <div class="choice-container">
            <strong> Should &nbsp;<a href="{{ url('/user/'. $report->infractor->id) }}"> &#64;{{$report->infractor->username}}</a> &nbsp; be banned? </strong>
            <div class="choices">
                <form action="{{ url('/report/'. $report->id . '/ban') }}" method="POST">
                    @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-ban"></i>
                    Ban User
                </button>
                </form>
                <form action="{{ url('/report/'. $report->id . '/close') }}" method="POST">
                    @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-check"></i>
                    Don't Ban User
                </button>
                </form>
            </div>
        <div>
        @endif
      </div>
    </div>
  </div>
</div>