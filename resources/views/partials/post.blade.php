<article class="post-container" id="post-id-{{$post->id}}">
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
            <div class="post-delete" data-id="{{$post->id}}">
                <img type="image" src="../trash-bin.png" alt="Delete Post">
            </div>
            @endif
        </div>
    </header>
    <div class="post-body">
        <a href="{{url('/post/'.$post->id)}}">
            @if ($post->media !== null)
                <img src="{{ url($post->media) }}" alt="{{ $post->text }}" class="post-img">
            @endif
            <div class="post-body-text">
                <p class="post-description">{{ $post->text }}</p>
                <p id="post-date">{{ $post->date }}</p>
            </div>
        </a>
    </div>
    <footer class="post-footer">
        <div class="post-footer-details">
            <ul class="post-footer-links">
                <button class="like-post">
                    <h5 class="like-count">
                    <i class="fa-regular fa-heart fa-3x" style="color: #cc0f0f;"></i>
                    {{count($post->likes())}}
                    </h5>
                </button>
                <button class="comment-post">
                    <h5 class="comment-count">
                    <i class="fa-regular fa-comment fa-3x"></i>
                    {{ count($post->comments) }}
                    </h5>
                </button>
                <button class="share-post">
                    <h5>
                    <i class="fa-solid fa-share-from-square fa-3x"></i>
                    </h5>
                </button>
            </ul>
        </div>
        <form action="{{ url('comment/create') }}" method="post" class="post-comment-form">
            @csrf
        </form>
        {{-- @include('partials.commentsection', ['post'=>$post]) --}}
    </footer>
</article>
