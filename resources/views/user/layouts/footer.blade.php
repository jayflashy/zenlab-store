<div class="dashboard-footer bottom-footer-two mt-32 border-0 bg-white">
    <div class="bottom-footer__inner flx-between gap-3">
        <p class="bottom-footer__text font-14">
            Copyright © {{ date('Y') }} {{ $settings->name }}, All rights reserved.
        </p>
        <div class="footer-links gap-4">
            <a href="{{ route('terms') }}" class="footer-link hover-text-heading font-14">Terms of service</a>
            <a href="{{ route('policy') }}" class="footer-link hover-text-heading font-14">Privacy Policy</a>
            <a href="{{ route('about') }}" class="footer-link hover-text-heading font-14">About</a>
        </div>
    </div>
</div>
