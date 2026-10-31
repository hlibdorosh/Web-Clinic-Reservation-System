@extends('layouts.public')
@section('title', 'Privacy policy')
@section('content')
@include('legal._draft-notice')

<h1 class="text-3xl font-medium text-ink-900 tracking-tight">Privacy policy</h1>
<p class="mt-2 text-sm text-ink-500">Last updated: [date]</p>

<div class="mt-8 space-y-8 text-sm leading-7 text-ink-600">

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">1. Who we are</h2>
        <p>The controller of personal data processed through this website is <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[legal name of the clinic]</mark>, Company ID <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[IČO]</mark>, <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[registered address]</mark>. Contact: <a href="mailto:info@interklinik.sk" class="text-ocean-700 underline">info@interklinik.sk</a>, <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[phone]</mark>.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">2. What we collect and why</h2>
        <ul class="list-disc pl-5 space-y-2">
            <li><strong class="text-ink-900">Account data</strong> (name, email address, password stored only as a hash, role, optional phone and bio). Used to create and secure your account and to contact you about it. Legal basis: performance of a contract (Art. 6(1)(b) GDPR).</li>
            <li><strong class="text-ink-900">Consent records</strong> (time you accepted the Terms, this policy and the age confirmation). Used to show that you agreed. Legal basis: legal obligation and our legitimate interest in keeping evidence (Art. 6(1)(c) and (f)).</li>
            <li><strong class="text-ink-900">Reservation data</strong> (doctor, department, service and time slot you booked, and reservation status). Used to run appointments. Legal basis: contract (Art. 6(1)(b)).</li>
            <li><strong class="text-ink-900">Health-related data</strong> you enter in your patient information (birth date, height, weight, sex), and notes that doctors record about a visit. This is a special category of data (Art. 9 GDPR). We process it only with your explicit consent, given on the patient information form, and for the provision of healthcare. Where healthcare record-keeping is required by law, we keep the data for the period that law requires.</li>
            <li><strong class="text-ink-900">Doctor profile data</strong> (name, photo, bio, and for doctors who connect them, Google Calendar tokens used to add confirmed visits to their calendar). Legal basis: contract, and consent for the Google Calendar connection, which can be disconnected at any time.</li>
            <li><strong class="text-ink-900">Notifications and technical data</strong> (in-app notifications about reservations, session records containing IP address and browser type, and server logs for security). Legal basis: contract and our legitimate interest in keeping the service secure (Art. 6(1)(f)).</li>
        </ul>
        <p class="mt-3">We do not use advertising or marketing profiles, and we do not sell personal data.</p>
    </section>

    <section id="health">
        <h2 class="text-lg font-medium text-ink-900 mb-2">3. Health information</h2>
        <p>Health information is sensitive. Every field in your patient information is optional, and you decide what to enter. Your consent to the processing of health information is recorded with a timestamp. You can withdraw it at any time by deleting your account (section 7). Withdrawal does not affect processing that already happened lawfully, and it may not stop us from keeping records the law requires us to keep.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">4. Who receives your data</h2>
        <ul class="list-disc pl-5 space-y-2">
            <li><strong class="text-ink-900">Clinic staff</strong> who need the information for your care and scheduling: the doctor you visit, and administrators who manage accounts.</li>
            <li><strong class="text-ink-900">Hosting and infrastructure providers</strong> that run the website and database, <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[hosting provider and location]</mark>, under data processing agreements.</li>
            <li><strong class="text-ink-900">Email delivery</strong>: account and reservation emails are sent through the mail service configured by the clinic, <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[provider]</mark>.</li>
            <li><strong class="text-ink-900">Google</strong>, only for doctors who choose to connect Google Calendar. Google receives the calendar events created for confirmed visits, which may include patient names.</li>
        </ul>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">5. Third-party services loaded by this website</h2>
        <p>The website loads the Figtree typeface from <strong class="text-ink-900">Bunny Fonts</strong> (fonts.bunny.net). Your browser connects to that service, which can see your IP address. We do not load analytics, advertising or social-media scripts.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">6. How long we keep data</h2>
        <ul class="list-disc pl-5 space-y-2">
            <li>Account data: until you delete your account, or for as long as needed for a dispute that is still open.</li>
            <li>Reservations and visit notes: <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[retention period, e.g. as required by Slovak healthcare record rules]</mark>, after which they are deleted or anonymised.</li>
            <li>Session records: removed when the session expires.</li>
            <li>Google Calendar tokens: until you disconnect Google Calendar.</li>
        </ul>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">7. Your rights</h2>
        <p>You have the right to access your data, correct it, have it deleted, restrict or object to its processing, receive a copy of it in a portable format, and withdraw consent where processing is based on consent. You can change most of your information in your profile and patient information pages. To delete your account and all associated data, use <a href="{{ route('profile.edit') }}" class="text-ocean-700 underline">Profile &rarr; Delete account</a>. Reservations and patient information are removed with the account. For any other request, see <a href="{{ route('legal.data-request') }}" class="text-ocean-700 underline">Data deletion and access requests</a>. We reply within one month.</p>
        <p class="mt-3">You can complain to the supervisory authority: <strong class="text-ink-900">Úrad na ochranu osobných údajov Slovenskej republiky</strong>, Hraničná 12, 820 07 Bratislava, <a href="https://dataprotection.gov.sk" class="text-ocean-700 underline" rel="noopener">dataprotection.gov.sk</a>.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">8. Children</h2>
        <p>You must be 16 or older to create an account yourself. A parent or guardian may create an account for a minor and must confirm this at registration. We may ask for proof of parental responsibility.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">9. Security</h2>
        <p>Passwords are stored as one-way hashes. Connections use HTTPS <mark class="bg-amber-100 text-ink-900 px-1 rounded-sm">[confirm HTTPS is enforced on the production host]</mark>. Access to administrative functions is restricted by role.</p>
    </section>

    <section>
        <h2 class="text-lg font-medium text-ink-900 mb-2">10. Changes</h2>
        <p>We will publish changes on this page and update the date above. For material changes we will also tell registered users.</p>
    </section>
</div>
@endsection
