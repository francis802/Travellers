@include('partials.topbar')

@section('feed')

<section id="feed">
    @yield('topbar')
    <section id="user-bar">
        <a href="{{ url('/user/'.Auth::user()->id) }}" class="profile-info">
            <div id="profile-picture">
                @if (Auth::user()->profile_photo !== null)
                    <img src="{{ url(Auth::user()->profile_photo) }}" alt="Profile Picture">
                @else
                <img src="{{ url('man.jpg') }}" alt="Profile Picture">
                @endif
            </div>
            @if (Auth::check())
                <h2 id="user-username">&#64;{{ Auth::user()->username }}</h2>
            @endif
        </a>
        <input id="search-input" type="text" placeholder="Search for users..." onkeydown="searchOnEnter(event)"> 
    </section>

    <section id="buttons">
        <button id="forYouButton" class="underline" onclick="toggleButton('forYouButton', 'fy-posts')">For You</button>
        <button id="followingButton" onclick="toggleButton('followingButton', 'following-posts')">Following</button>
    </section>

    <script>
        
        function toggleButton(buttonId, sectionId) {
            const buttons = document.querySelectorAll('#buttons button');
            buttons.forEach(button => {
                button.classList.remove('underline');
            });
            const selectedButton = document.getElementById(buttonId);
            selectedButton.classList.add('underline');

            document.getElementById('fy-posts').style.display = 'none';
            document.getElementById('following-posts').style.display = 'none';

            document.getElementById(sectionId).style.display = 'flex';
        }

        function searchOnEnter(event) {
            if (event.key === 'Enter') {
                const searchValue = document.getElementById('search-input').value;
                window.location.href = "{{ url('/search/') }}?query=" + encodeURIComponent(searchValue);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('following-posts').style.display = 'none';
        });

    </script>
    
    <section id="fy-posts">
        <ul id="user-post-list">
            @foreach($publicPosts->sortByDesc('date') as $post)
                @include('partials.post')
            @endforeach
        </ul>
    </section>

    <section id="following-posts">
        <ul id="user-post-list">
            @foreach($followingPosts->sortByDesc('date') as $post)
                @include('partials.post')
            @endforeach
        </ul>
    </section>
    
</section>

@endsection
