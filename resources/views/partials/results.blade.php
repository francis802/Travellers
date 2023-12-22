@include('partials.topbar')

@section('results')
    <section  id="results">
        @yield('topbar')
        <section id="results">
            <section id="search-results-header" class="search-header">
                <h2>Search Results For: "{{ $input }}"</h2>
            </section>

            <section id="buttons">
                <button id="usersButton" class="underline" onclick="toggleSearchButton('usersButton', 'user-bar')">Users</button>
                <button id="groupsButton" onclick="toggleSearchButton('groupsButton', 'groups')">Groups</button>
                <button id="postsButton" onclick="toggleSearchButton('postsButton', 'posts')">Posts</button>
            </section>

            <button id="select-date-range" onclick="toggleDateRange()">[Select Date Range]</button>

            <section id="date-range">
                <input type="hidden" name="query-result" value="{{$input}}">
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start-date">

                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end-date">

                <button type="button" id="apply-date-range" onclick="applyDateRange()">Apply Date Range</button>
            </section>

            <section id="user-bar">
            @if($userResults->count() > 0)
                    @foreach($userResults as $user)
                        <a href="{{ url('/user/'.$user->id) }}" class="profile-info">
                            <div id="profile-picture">
                                @if($user->profile_photo == null)
                                <img src="{{url('man.jpg')}}" alt="Profile Picture">
                                @else
                                <img src="{{url($user->profile_photo)}}" alt="Profile Picture">
                                @endif
                            </div>
                            @if (Auth::check())
                                <h2 id="user-username">&#64;{{ $user->username }}</h2>
                            @endif
                        </a>
                    @endforeach
            @else
                <p>No users found.</p>
            @endif
            </section>

            <section id="groups">
            @if($groupResults->count() > 0)
                    @foreach($groupResults as $group)
                        <li class="group-in-list">
                        <a href="{{ url('/group/'.$group->id) }}" class="group-in-list-name">
                        {{ $group->description }}
                        </a>
                        </li>
                    @endforeach
            @else
                <p>No groups found.</p>
            @endif
            </section>

            <section id="posts">
            @if(count($postResults) > 0)
            <ul id="user-post-list">
                @foreach($postResults as $post)
                    @include('partials.post', ['post' => $post])
                @endforeach
            </ul>
            </section>
            @else
                <p>No posts found.</p>
            @endif                                                   
            </section>

    </section>
@endsection
