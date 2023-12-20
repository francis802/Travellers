@include('partials.topbar')

@section('results')
    <section  id="feed">
        @yield('topbar')
        <section id="results">
            <section id="search-results-header" class="search-header">
                <h2>Search Results For: "{{ $input }}"</h2>
            </section>
            
            @if($searchResults->count() > 0)
                    @foreach($searchResults as $user)
                    <section id="user-bar">
                        <a href="{{ url('/user/'.$user->id) }}" class="profile-info">
                            <div id="profile-picture">
                                <img src="../man.jpg" alt="Profile Picture">
                            </div>
                            @if (Auth::check())
                                <h2 id="user-username">&#64;{{ $user->username }}</h2>
                            @endif
                        </a>
                    </section>
                    @endforeach
            @else
                <p>No results found.</p>
            @endif
    </section>
@endsection