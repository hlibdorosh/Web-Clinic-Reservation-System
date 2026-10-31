{{-- Notice only: the site sets just essential cookies (session, CSRF, remember-me), so no opt-in is needed.
     Non-essential cookies are not set; if analytics or marketing cookies are ever added, this must become a real consent choice. --}}
<div id="cookie-notice" hidden role="region" aria-label="Cookie notice" class="fixed inset-x-0 bottom-0 z-[60] p-4">
    <div class="max-w-3xl mx-auto bg-white border border-line-strong rounded-xl shadow-lg p-4 sm:flex sm:items-center sm:gap-6">
        <p class="text-sm text-ink-600 leading-6 flex-1">
            We use only essential cookies, for example to keep you logged in and to protect forms. We do not use advertising or analytics cookies.
            <a href="{{ route('legal.cookies') }}" class="text-ocean-700 underline hover:no-underline">Cookie policy</a>
        </p>
        <button type="button" id="cookie-notice-dismiss"
                class="btn btn-sm mt-3 sm:mt-0 shrink-0">
            Got it
        </button>
    </div>
</div>

<script>
    (function () {
        var notice = document.getElementById('cookie-notice');
        var button = document.getElementById('cookie-notice-dismiss');
        if (!notice || !button) return;

        var seen = false;
        try { seen = localStorage.getItem('cookieNoticeSeen') === '1'; } catch (e) {}
        if (!seen) notice.hidden = false;

        button.addEventListener('click', function () {
            try { localStorage.setItem('cookieNoticeSeen', '1'); } catch (e) {}
            notice.hidden = true;
        });
    })();
</script>
