@include('partials.topbar')

@section('results')
    <section  id="feed">
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

            <script>
                function toggleSearchButton(buttonId, sectionId) {
                    const buttons = document.querySelectorAll('#buttons button');
                    buttons.forEach(button => {
                        button.classList.remove('underline');
                    });
                    const selectedButton = document.getElementById(buttonId);
                    selectedButton.classList.add('underline');

                    document.getElementById('user-bar').style.display = 'none';
                    document.getElementById('groups').style.display = 'none';
                    document.getElementById('posts').style.display = 'none';

                    document.getElementById(sectionId).style.display = 'flex';
                }

                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('groups').style.display = 'none';
                    document.getElementById('posts').style.display = 'none';
                });
            </script>

            <section id="user-bar">
            @if($userResults->count() > 0)
                    @foreach($userResults as $user)
                        <a href="{{ url('/user/'.$user->id) }}" class="profile-info">
                            <div id="profile-picture">
                                <img src="../man.jpg" alt="Profile Picture">
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
            @if($postResults->count() > 0)
            <ul id="user-post-list">
                @foreach($postResults as $post)
                    @include('partials.post', ['post' => $post])
                @endforeach
            </ul>
            @else
                <p>No posts found.</p>
            @endif                                                   
            </section>

    </section>
@endsection
