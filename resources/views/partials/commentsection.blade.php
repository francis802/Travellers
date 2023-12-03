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