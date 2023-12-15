@include('partials.topbar')


@section('memberInList')
<section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
        <h2>Members</h2>
        <ul class="list-group list-group-flush">
        @foreach($members as $member)
            <li data-id="{{$group->id}}" data-user-id="{{$member->user()->id}}" class="list-group-item list-group-item-light">
                <a href="{{ url('/user/'.$member->user()->id) }}">
                    <div class="notification-info">
                        <img width="40em" height="40em" src="{{ url($member->user()->profile_photo) }}">
                        <p class="notification-text">{{$member->user()->name}}</p>
                    </div>
                </a>
                @if (Auth::user()->isOwner($group->id) || Auth::user()->isAdmin())
                    <button class="remove-member button" data-id="{{$group->id}}" onclick="removeMemberRequest(this)">Remove</button>
                    @if(!$member->user()->isOwner($group->id))
                        <button class="upgrade-member button" data-id="{{$group->id}}" onclick="upgradeToOwnerRequest(this)">Make Owner</button>
                    @endif
                @endif
            </li>
        @endforeach
        </ul>
    </section>
</section>
@endsection