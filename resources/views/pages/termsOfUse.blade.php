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
                <p class="text-break sp-p">By using Travellers, you agree to comply with and be bound by these Terms and Conditions of Use ("Terms"). If you do not agree with any part of these Terms, you may not use the Platform.</p>

                <h2 class="h2-terms">2. Eligibility</h2>
                <p class="text-break sp-p">You must be at least 18 years old to use the Platform. By using the Platform, you confirm that you are at least 18 years of age.</p>

                <h2 class="h2-terms">3. User Accounts</h2>
                <ol>
                    <li><p class="text-break sp-p">You are responsible for maintaining the confidentiality of your account credentials and are solely responsible for all activities that occur under your account.</p></li>
                    <li><p class="text-break sp-p">You agree to provide accurate and current information during the registration process and to update such information to keep it accurate and current.</p></li>
                </ol>

                <h2 class="h2-terms">4. Content Submission</h2>
                <ol>
                    <li><p class="text-break sp-p">Users may submit text, photos, videos, and other content ("User Content") to the Platform.</p></li>
                    <li><p class="text-break sp-p">By submitting User Content, you grant Traveller a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, publish, distribute, and display the User Content.</p></li>
                </ol>

                <h2 class="h2-terms">5. Code of Conduct</h2>
                <ol>
                    <li><p class="text-break sp-p">Users must not engage in any conduct that is unlawful, offensive, or harmful to others.</p></li>
                    <li><p class="text-break sp-p">Users must not post content that is discriminatory, harassing, defamatory, or otherwise objectionable.</p></li>
                    <li><p class="text-break sp-p">Users must respect the privacy of others and refrain from sharing personal information without consent.</p></li>
                </ol>

                <h2 class="h2-terms">6. Travel Safety</h2>
                <ol>
                    <li><p class="text-break sp-p">Users are solely responsible for their own safety and well-being during travel.</p></li>
                    <li><p class="text-break sp-p">Traveller does not endorse or guarantee the accuracy of travel information shared on the Platform.</p></li>
                </ol>

                <h2 class="h2-terms">7. Intellectual Property</h2>
                <ol>
                    <li><p class="text-break sp-p">All trademarks, logos, and copyrighted material on the Platform are the property of [Your Company Name] or its licensors.</p></li>
                    <li><p class="text-break sp-p">Users must not use, reproduce, or distribute any content from the Platform without prior written permission.</p></li>
                </ol>

                <h2 class="h2-terms">8. Termination</h2>
                <ol>
                    <li><p class="text-break sp-p">Traveller reserves the right to terminate or suspend user accounts for violations of these Terms.</p></li>
                    <li><p class="text-break sp-p">Users may terminate their accounts at any time by following the provided instructions.</p></li>
                </ol>

                <h2 class="h2-terms">9. Changes to Terms</h2>
                <p class="text-break sp-p">Traveller reserves the right to modify or replace these Terms at any time. Users will be notified of significant changes.</p>

                <h2 class="h2-terms">10. Disclaimer of Warranties</h2>
                <p class="text-break sp-p">These Terms shall be governed by and construed in accordance with the laws of Portugal.</p>

                <h2 class="h2-terms">11. Governing Law</h2>
                <p class="text-break sp-p">The Platform is provided "as is" and without warranties of any kind, either express or implied.</p>

                <h2 class="h2-terms">12. Governing Law</h2>
                <p class="text-break sp-p">These Terms shall be governed by and construed in accordance with the laws of Portugal.</p>
            </div>
        </section>
    </section>

@endsection