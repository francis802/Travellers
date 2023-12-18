@extends('layouts.app')

@section('title', 'Home')
@include('partials.bar')
@include('partials.topbar')

@section('content')
    @yield('bar')
    <section id="feed">
    @yield('topbar')
    <header class="faq-header">
    <h1>Frequently Asked Questions (FAQs)</h1>
    @if(Auth::user()->isAdmin())
    <button class="btn btn-success">
        <i class="fa-solid fa-plus"></i>
    </button>
    @endif
    </header>
    <div class="accordion" id="faqs">
    @foreach($faqs as $faq)
        <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer-faq-{{$faq->id}}" aria-expanded="false" aria-controls="answer-faq-{{$faq->id}}">
            {{$faq->question}}
        </button>
        </h2>
        <div id="answer-faq-{{$faq->id}}" class="accordion-collapse collapse" data-bs-parent="#faqs">
        <div class="accordion-body">
            {{$faq->answer}}
        </div>
        </div>
    @endforeach
    </div>

    </section>
    
@endsection
