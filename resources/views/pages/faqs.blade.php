@extends('layouts.app')

@include('partials.bar')
@include('partials.topbar')

@section('title')
    FAQs | Travellers
@endsection

@section('content')
    @yield('bar')
    <section id="feed">
    @yield('topbar')
    <section class="notifications-container" >
    <header class="faq-header">
        <h2>Frequently Asked Questions (FAQs)</h2>
        @if(Auth::user()->isAdmin())
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="fa-solid fa-plus"></i> Add FAQ
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
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newFaqForm" action="{{ route('addFaq') }}" method="POST">
                <div class="modal-body">
                        @csrf
                        <label for="newQuestion">Question</label>
                        <input type="text" id="newQuestion" name="newQuestion" class="form-control" required>

                        <label for="newAnswer">Answer</label>
                        <textarea id="newAnswer" name="newAnswer" class="form-control" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Add FAQ</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </section>
    </section>
    
@endsection
