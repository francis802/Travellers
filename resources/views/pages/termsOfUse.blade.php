@extends('layouts.app')
@include('partials.bar')
@include('partials.topbar')

@section('content')
@yield('bar')
    <section id="feed">
        @yield('topbar')
        <section class="notifications-container" >
            <h1>Terms and Conditions of Use</h1>
            <div class="divider">
                <h2 class="h2-terms">1. Acceptance of Terms</h2>
                <p>By using Travellers, you agree to comply with and be bound by these Terms and Conditions of Use ("Terms"). If you do not agree with any part of these Terms, you may not use the Platform.</p>

                <h2 class="h2-terms">2. Eligibility</h2>
                <p>You must be at least 18 years old to use the Platform. By using the Platform, you confirm that you are at least 18 years of age.</p>

                <h2 class="h2-terms">3. User Accounts</h2>
                <ol>
                    <li>You are responsible for maintaining the confidentiality of your account credentials and are solely responsible for all activities that occur under your account.</li>
                    <li>You agree to provide accurate and current information during the registration process and to update such information to keep it accurate and current.</li>
                </ol>

                <h2 class="h2-terms">4. Content Submission</h2>
                <ol>
                    <li>Users may submit text, photos, videos, and other content ("User Content") to the Platform.</li>
                    <li>By submitting User Content, you grant Traveller a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, publish, distribute, and display the User Content.</li>
                </ol>

                <h2 class="h2-terms">5. Code of Conduct</h2>
                <ol>
                    <li> Users must not engage in any conduct that is unlawful, offensive, or harmful to others.</li>
                    <li> Users must not post content that is discriminatory, harassing, defamatory, or otherwise objectionable.</li>
                    <li>Users must respect the privacy of others and refrain from sharing personal information without consent.</li>
                </ol>

                <h2 class="h2-terms">6. Travel Safety</h2>
                <ol>
                    <li>Users are solely responsible for their own safety and well-being during travel.</li>
                    <li> [Your Social Network Name] does not endorse or guarantee the accuracy of travel information shared on the Platform.</li>
                </ol>

                <h2 class="h2-terms">7. Intellectual Property</h2>
                <ol>
                    <li>All trademarks, logos, and copyrighted material on the Platform are the property of [Your Company Name] or its licensors.</li>
                    <li> Users must not use, reproduce, or distribute any content from the Platform without prior written permission.</li>
                </ol>

                <h2 class="h2-terms">8. Termination</h2>
                <ol>
                    <li>[Your Social Network Name] reserves the right to terminate or suspend user accounts for violations of these Terms.</li>
                    <li>Users may terminate their accounts at any time by following the provided instructions.</li>
                </ol>

                <h2 class="h2-terms">9. Changes to Terms</h2>
                <p>[Your Social Network Name] reserves the right to modify or replace these Terms at any time. Users will be notified of significant changes.</p>

                <h2 class="h2-terms">10. Disclaimer of Warranties</h2>
                <p>These Terms shall be governed by and construed in accordance with the laws of [Your Country/State].</p>

                <h2 class="h2-terms">11. Governing Law</h2>
                <p>The Platform is provided "as is" and without warranties of any kind, either express or implied.</p>

                <h2 class="h2-terms">12. Governing Law</h2>
                <p>These Terms shall be governed by and construed in accordance with the laws of [Your Country/State].</p>
            </div>
        </section>
    </section>

@endsection