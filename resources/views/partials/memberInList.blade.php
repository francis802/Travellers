@include('partials.topbar')


@section('memberInList')
<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
        <h2>Members</h2>
        @if($members->isEmpty())
            <p >This group don´t have any member...</p>
        @else
            <ul class="list-group list-group-flush">
            @foreach($members as $member)
                <li id="notification-list" data-id="{{$group->id}}" data-user-id="{{$member->user()->id}}" class="list-group-item list-group-item-light">
                    <a href="{{ url('/user/'.$member->user()->id) }}">
                        <div class="notification-info">
                            @if($member->user()->profile_photo == null)
                            <img class="img-notification img-user" src="{{ url('man.jpg') }}">
                            @else
                            <img class="img-notification img-user" src="{{ url($member->user()->profile_photo) }}">
                            @endif
                            <p class="notification-text">{{$member->user()->name}}</p>
                        </div>
                    </a>
                    @if (Auth::user()->isOwner($group->id) || Auth::user()->isAdmin())
                            <button type="button" class="remove-member btn btn-primary" data-id="{{$group->id}}" onclick="removeMemberRequest(this)">Remove</button>
                        @if(!$member->user()->isOwner($group->id))
                            <button type="button" class="upgrade-member btn btn-primary" data-id="{{$group->id}}" onclick="upgradeToOwnerRequest(this)">Make Owner</button>
                        @endif
                    @endif
                </li>
            @endforeach
            </ul>
        @endif
    </section>
</section>
@endsection