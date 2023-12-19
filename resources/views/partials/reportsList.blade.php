<div class="table-responsive">
<table class="table {{$type}}">
  <thead>
    <tr>
      <th scope="col">Reporter</th>
      <th scope="col">Infractor</th>
      <th scope="col">Time</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reports as $report)
        <tr>
            <td scope="row">
                <a href="{{ url('/user/'. $report->reporter->id) }}" class="profile-info">
                    <div id="profile-picture-sml">
                        @if ($report->reporter->profile_photo !== null)
                            <img src="{{ url($report->reporter->profile_photo) }}" alt="Profile Picture">
                        @else
                        <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                        @endif
                    </div>
                    <h2 id="user-username">&#64;{{ $report->reporter->username }}</h2>
                </a>
            </td>
            <td scope="row">
                <a href="{{ url('/user/'. $report->infractor->id) }}" class="profile-info">
                    <div id="profile-picture-sml">
                        @if ($report->infractor->profile_photo !== null)
                            <img src="{{ url($report->infractor->profile_photo) }}" alt="Profile Picture">
                        @else
                        <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                        @endif
                    </div>
                    <h2 id="user-username">&#64;{{ $report->infractor->username }}</h2>
                </a>
            </td>
            <td>{{$report->date->diffForHumans()}}</td>
            <td>
                @include('partials.report', ['report' => $report])
            </td>
      </tr>
    @endforeach
  </tbody>
</table>
</div>