<div class="{{$type}}">
@foreach ($appeals as $appeal)
                <div class="card mb-3" id="appeal-{{$appeal->id}}">
                <div class="card-header">
                <a href="{{ url('/user/'. $appeal->banned_user->id) }}" class="profile-info">
                    <div id="profile-picture-sml">
                        @if ($appeal->banned_user->profile_photo !== null)
                            <img src="{{ url($appeal->banned_user->profile_photo) }}" alt="Profile Picture">
                        @else
                        <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                        @endif
                    </div>
                    <h2 id="user-username">&#64;{{ $appeal->banned_user->username }}</h2>
                </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$appeal->title}}</h5>
                    <p class="card-text">{{$appeal->description}}</p>
                    @include('partials.reportsOnUser', ['user' => $appeal->banned_user])
                    <p class="card-text"><small class="text-body-secondary">{{ $appeal->date->diffForHumans() }}</small></p>
                </div>
                @if ($appeal->accept_appeal === null)
                <div class="card-footer text-body-secondary text-center">
                    <button type="button" class="btn btn-secondary unban-user" data-id="{{$appeal->id}}">Unban User</button>
                    <button type="button" class="btn btn-danger reject-appeal" data-id="{{$appeal->id}}">Reject Appeal</button>
                </div>
                @elseif ($appeal->accept_appeal === true)
                <div class="card-footer text-body-secondary text-center">
                    Outcome: 
                    <button type="button" class="btn btn-sucess reject-appeal" data-id="{{$appeal->id}}" disabled>User Unbanned</button>
                </div>
                @elseif ($appeal->accept_appeal === false)
                <div class="card-footer text-body-secondary text-center">
                    Outcome:
                    <button type="button" class="btn btn-danger reject-appeal" data-id="{{$appeal->id}}" disabled>Appeal Rejected</button>
                </div>
                @endif
                </div>
        @endforeach
</div>