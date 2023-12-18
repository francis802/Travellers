<div class="table-responsive">
<table class="table {{$type}}">
  <thead>
    <tr>
    @if (route('admin.helps') == url()->current())
      <th scope="col">User</th>
    @else
        <th scope="col">#</th>
    @endif
      <th scope="col">Question</th>
      <th scope="col">Date</th>
      <th scope="col"></th>
      @if (route('admin.helps') == url()->current())
      <th scope="col"></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($helps as $help)
        <tr>
        @if (route('admin.helps') == url()->current())
            <th scope="row">
                <a href="{{ url('/user/'. $help->user->id) }}" class="profile-info">
                    <div id="profile-picture">
                        @if (Auth::user()->profile_photo !== null)
                            <img src="{{ url($help->user->profile_photo) }}" alt="Profile Picture">
                        @else
                        <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                        @endif
                    </div>
                    <h2 id="user-username">&#64;{{ $help->user->username }}</h2>
                </a>
            </th>
        @else
            <th scope="row">{{$loop->index + 1}}</th>
        @endif
            <td>{{$help->title}}</td>
            <td>{{$help->date}}</td>
            <td>
                <a href="{{url('/help/'.$help->id)}}" class="btn btn-primary">View</a>
            </td>

        @if (route('admin.helps') == url()->current() && $help->answer != null)
        <td>
          <form action="{{url('/faq/create/')}}" method="POST">
            @csrf
            <input type="hidden" name="question" value="{{$help->title}}">
            <input type="hidden" name="answer" value="{{$help->answer}}">
            <input type="hidden" name="help_id" value="{{$help->id}}">
            <button type="submit" class="btn btn-success {{$help->became_faq ? 'disabled':''}}">Create FAQ</button>
          </form>
        </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
</div>