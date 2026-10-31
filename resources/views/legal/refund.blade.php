@extends('layouts.public')
@section('title', 'Refund policy')
@section('content')
@include('legal._draft-notice')

<h1 class="text-3xl font-medium text-ink-900 tracking-tight">Refund policy</h1>
<p class="mt-2 text-sm text-ink-500">Last updated: [date]</p>

<div class="mt-8 space-y-8 text-sm leading-7 text-ink-600">
    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">No online payments</h2>
        <p>This website does not take payments. Reserving an appointment is free. Service prices shown on the website are for information only, and you pay for services at the clinic.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">If you have already paid</h2>
        <p>If you paid at the clinic and the clinic cancels the visit, you are entitled to a refund of the amount paid. Contact us at <a href="mailto:info@interklinik.sk" class="text-ocean-700 underline">info@interklinik.sk</a> with your reservation date and the amount. We will reply within <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[number]</mark> working days.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Cancelling your own visit</h2>
        <p>You can cancel a reservation from your reservations page. <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[State whether any amount is refundable on patient cancellation, and the notice period.]</mark></p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">Statutory rights</h2>
        <p>Nothing in this policy affects your rights under Slovak consumer protection law.</p>
    </section>
</div>
@endsection
