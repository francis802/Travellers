@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('title')
    About Us | Travellers
@endsection

@section('content')
@yield('bar')
    <section id="feed">
        @yield('topbar')
        <section class="notifications-container" >
            <h1>About Us - Traveller</h1>
            <div class="divider">
                <p class="text-break sp-p">The project was born out of a semester's work in the "Database and Web Applications Laboratory" course in the Degree in Informatics and Computer Engineering at the Faculty of Engineering of the University of Porto and the idea came from our special love of travelling and getting to know the world.</p>

                <p class="text-break sp-p">This product is designed with individual users in mind, catering to those who wish to share their travel experiences and discover what fellow travellers are doing in specific cities or countries.</p>

                <p class="text-break sp-p">The primary aim of this project is to create a social media website that serves as a global hub for travellers around the world, allowing them to connect and exchange their individual experiences. Users have the ability to share their travel stories, access content related to the countries they are visiting, and communicate with both local residents and fellow travellers.</p>

                <p class="text-break sp-p">We hope you enjoy using our website as much as we enjoyed creating it!</p>
            </div>
        </section>
        <div class="container-md photos-about">
            <div class="person-container d-inline-block">
                <img src="../admin1.jpg" class="img-thumbnail about-img" alt="...">
                <p class="text-break sp-p">francisco Campos</p>
            </div>

            <div class="person-container d-inline-block">
                <img src="../admin2.png" class="img-thumbnail about-img" alt="...">
                <p class="text-break sp-p">António Romão</p>
            </div>

            <div class="person-container d-inline-block">
                <img src="../admin3.jpg" class="img-thumbnail about-img" alt="...">
                <p class="text-break sp-p" >Henrique Pinheiro</p>
            </div>
        </div>
    </section>

@endsection