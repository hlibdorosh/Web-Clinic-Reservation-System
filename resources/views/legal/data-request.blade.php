@extends('layouts.public')
@section('title', 'Data deletion and access requests')
@section('content')
@include('legal._draft-notice')

<h1 class="text-3xl font-medium text-ink-900 tracking-tight">Data deletion and access requests</h1>

<div class="mt-8 space-y-8 text-sm leading-7 text-ink-600">
    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Delete your account (self-service)</h2>
        <p>Logged-in users can delete their account at any time under <a href="{{ route('profile.edit') }}" class="text-ocean-700 underline">Profile &rarr; Delete account</a>. You confirm with your password. Deletion removes your account, your patient information and your reservations, and the Google Calendar tokens stored for your account. Backups may keep a copy for <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[backup retention period]</mark>, after which it is overwritten.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Request by email</h2>
        <p>If you cannot log in, or you want a copy of your data, a correction, or a restriction on processing, email <a href="mailto:info@interklinik.sk?subject=Data%20request" class="text-ocean-700 underline">info@interklinik.sk</a> from the address on your account, with the subject "Data request". We may ask you to prove your identity before we act.</p>
        <p class="mt-3">We respond within one month of receiving a complete request.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Records we must keep</h2>
        <p>Some healthcare records must be kept for a fixed period under Slovak law. If a deletion request conflicts with that obligation, we will tell you which records we keep and why.</p>
    </section>
</div>
@endsection
