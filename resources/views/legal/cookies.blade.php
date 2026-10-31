@extends('layouts.public')
@section('title', 'Cookie policy')
@section('content')
@include('legal._draft-notice')

<h1 class="text-3xl font-medium text-ink-900 tracking-tight">Cookie policy</h1>
<p class="mt-2 text-sm text-ink-500">Last updated: [date]</p>

<div class="mt-8 space-y-8 text-sm leading-7 text-ink-600">
    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">What we use</h2>
        <p>We use only cookies that are strictly necessary for the website to work. We do not use advertising, analytics or social-media cookies, so there is nothing to opt into.</p>
        <table class="mt-4 w-full text-left border border-line rounded-lg overflow-hidden">
            <thead class="bg-ink-50 text-ink-900">
                <tr>
                    <th scope="col" class="px-4 py-2 font-medium">Cookie</th>
                    <th scope="col" class="px-4 py-2 font-medium">Purpose</th>
                    <th scope="col" class="px-4 py-2 font-medium">Duration</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                <tr>
                    <td class="px-4 py-2 font-mono text-xs">{{ config('session.cookie') }}</td>
                    <td class="px-4 py-2">Keeps you logged in during your visit.</td>
                    <td class="px-4 py-2">Session. Expires after {{ config('session.lifetime') }} minutes of inactivity.</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-mono text-xs">XSRF-TOKEN</td>
                    <td class="px-4 py-2">Protects forms against cross-site request forgery.</td>
                    <td class="px-4 py-2">Session.</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-mono text-xs">remember_web_*</td>
                    <td class="px-4 py-2">Keeps you logged in if you tick "Remember me" when logging in.</td>
                    <td class="px-4 py-2">Up to 5 years, or until you log out.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Local storage</h2>
        <p>When you click "Got it" on the cookie notice, we store one flag in your browser's local storage so the notice is not shown again. It contains no personal data.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Managing cookies</h2>
        <p>You can delete cookies in your browser settings, but this logs you out. Blocking the essential cookies will stop the login and booking forms from working.</p>
    </section>
</div>
@endsection
