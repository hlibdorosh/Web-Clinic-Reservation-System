@extends('layouts.public')
@section('title', 'Terms of service')
@section('content')
@include('legal._draft-notice')

<h1 class="text-3xl font-medium text-ink-900 tracking-tight">Terms of service</h1>
<p class="mt-2 text-sm text-ink-500">Last updated: [date]</p>

<div class="mt-8 space-y-8 text-sm leading-7 text-ink-600">
    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">1. The service</h2>
        <p>This website lets patients of <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[clinic legal name]</mark> ("the clinic") view doctors and departments, request appointments from free time slots, and manage their own reservations. Doctors use it to publish free time and confirm or cancel reservations.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">2. Not for emergencies</h2>
        <p>Do not use this website to report an emergency or to request urgent care. In an emergency call <strong class="text-ink-900">112</strong>. <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[Confirm the clinic's emergency service details before publishing.]</mark></p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">3. Accounts and accuracy</h2>
        <p>You must give accurate information and keep your password secret. Tell us promptly if you think someone else has used your account. You must be 16 or older, or have a parent or guardian create the account for you.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">4. Reservations and cancellation</h2>
        <p>You can cancel your own reservation from your reservations page. Doctors may cancel a reservation if they cannot attend, and we will tell you. Late-cancellation rules and any fee for missed appointments are set by the clinic <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[state the rule, or write "none"]</mark>.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">5. Prices and payment</h2>
        <p>Service prices shown on this website are for information. Payment for services is made at the clinic. See the <a href="{{ route('legal.refund') }}" class="text-ocean-700 underline">Refund policy</a>.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">6. Medical information</h2>
        <p>Information on this website is general. It does not replace advice from a doctor, and medical decisions are made during your visit.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">7. Acceptable use</h2>
        <p>Do not try to access other people's accounts or data, upload harmful files, or use the service for anything unlawful. We may suspend accounts that break these rules.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">8. Liability</h2>
        <p>We work to keep the service available and correct, but we do not guarantee uninterrupted access. To the extent the law allows, we exclude liability for indirect loss. This does not limit liability that cannot be excluded under Slovak law, including liability for personal injury caused by negligence.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">9. Privacy</h2>
        <p>How we process personal data is described in our <a href="{{ route('legal.privacy') }}" class="text-ocean-700 underline">Privacy policy</a>.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">10. Governing law</h2>
        <p>These terms are governed by the laws of the Slovak Republic. <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[Confirm the competent court and the out-of-court dispute resolution body.]</mark></p>
    </section>
</div>
@endsection
