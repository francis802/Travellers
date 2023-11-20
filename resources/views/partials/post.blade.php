@section('post')
    <article id="post">
        <header id="post-header">
            <div id="post-author">
                <a href="{{ url('/user/'.$post->author->id) }}" class="post-author-name">
                    {{ $post->author->name }}
                </a>
            </div>
            <div id="edit-delete-post">
                @if ($post->author->id == Auth::user()->id)
                    <a href="{{ url('/post/'.$post->id.'/edit') }}" class="post-edit">
                        <img src="../pen.png" alt="Edit Post">
                    </a>
                @endif
                @if ($post->author->id == Auth::user()->id || Auth::user()->isAdmin())
                    <form method="post" action="{{ url('/post/'.$post->id.'/delete') }}">
                        @csrf
                        <input type="image" src="../trash-bin.png" alt="Delete Post" class="post-delete">
                    </form>
                @endif
            </div>
        </header>
        <div class="post-body">
            @if ($post->media !== null)
                <img src="{{ url($post->media) }}" alt="{{ $post->text }}" class="post-img">
            @endif
            <div class="post-body-text">
                <p class="post-description">{{ $post->text }}</p>
                <p id="post-date">{{ $post->date }}</p>
            </div>
        </div>
        <footer class="post-footer">
            <div class="post-footer-details">
                <ul class="post-footer-links">
                    <img src="../heart-empty.png" alt="Like Post">
                    <img src="../comment.png" alt="Comment">
                    <img src="../send.png" alt="Share">
                </ul>
            </div>
            <ul class="post-comments-list">
                @foreach ($post->comments as $comment)
                    <li class="post-comment">
                        <div class="post-comment-author">
                            <a href="{{ url('/user/'.$comment->author->id) }}" class="post-comment-author-name">
                                {{ $comment->author->name }}
                            </a>
                        </div>
                        <p class="post-comment-text">{{ $comment->text }}</p>
                    </li>
                @endforeach
            </ul>
            <form action="{{ url('comment/create') }}" method="post" class="post-comment-form">
                @csrf
            </form>
        </footer>
    </article>
@endsection