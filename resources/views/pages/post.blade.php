@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')


@section('content')
    <section class="inner-content">
        @yield('bar')
        <article class="post">
            <header class="post-header">
                <div class="post-author">
                    <a href="{{ url('/user/'.$post->author->id) }}" class="post-author-link">
                        <h4 class="post-author-name">{{ $post->author->name }}</h4>
                    </a>
                </div>
                <p class="post-time">{{ $post->date }}</p>
            </header>
            <div class="post-body">
                <img src="{{ url($post->media) }}" alt="{{ $post->text }}" class="post-img">
                <p class="post-description">{{ $post->text }}</p>
            </div>
            <footer class="post-footer">
                <div class="post-footer-details">
                    <ul class="post-footer-links">
                        <li><a href="#" class="post-footer-link">Like</a></li>
                        <li><a href="#" class="post-footer-link">Comment</a></li>
                        <li><a href="#" class="post-footer-link">Share</a></li>
                    </ul>
                </div>
                <ul class="post-comments-list">
                    @foreach ($post->comments as $comment)
                        <li class="post-comment">
                            <div class="post-comment-author">
                                <a href="{{ url('/user/'.$comment->author->id) }}" class="post-comment-author-link">
                                    <h4 class="post-comment-author-name">{{ $comment->author->name }}</h4>
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
    </section>
    
@endsection