<style>
.smart-footer {
    background: #3A2920;
    color: #F5EBDD;
    border-top: 3px solid #D94F16;
    margin-top: 0; /* removes the blank band that used to sit above the footer */
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.footer-content {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 clamp(20px, 5vw, 80px);
}

/* ── Trust strip ── */
.footer-features {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 30px 0;
}
.footer-feature {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 4px 24px;
    border-left: 1px solid rgba(245, 235, 221, 0.18);
}
.footer-feature:first-child { border-left: none; padding-left: 0; }
.footer-feature svg { width: 44px; height: 44px; flex-shrink: 0; color: #F2A33A; }
.footer-feature h3 { margin: 0 0 4px; font-size: 0.92rem; font-weight: 600; color: #ffffff; }
.footer-feature p  { margin: 0; font-size: 0.8rem; line-height: 1.45; color: rgba(245, 235, 221, 0.72); }

/* ── Bottom bar ── */
.footer-year {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 22px 0 26px;
    border-top: 1px solid rgba(245, 235, 221, 0.15);
    font-size: 0.95rem;
    color: #F5EBDD;
    text-align: center;
}

.footer-dev-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #C9B8A6;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 8px 16px;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.05);
}
.footer-dev-link:hover {
    color: #F5C400;
    background: rgba(245, 196, 0, 0.1);
    transform: translateY(-2px);
}

@media (max-width: 1024px) {
    .footer-features { grid-template-columns: repeat(2, 1fr); row-gap: 24px; }
    .footer-feature:nth-child(3) { border-left: none; padding-left: 0; }
}
@media (max-width: 600px) {
    .footer-features { grid-template-columns: 1fr; }
    .footer-feature, .footer-feature:nth-child(3) { border-left: none; padding-left: 0; }
}
</style>

<footer class="smart-footer">
    <div class="footer-content">

        <div class="footer-features">
            <div class="footer-feature">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 30v-5l4-9a3 3 0 0 1 2.7-1.8h18.6A3 3 0 0 1 36 16l4 9v5"/>
                    <rect x="6" y="25" width="36" height="9" rx="3"/>
                    <circle cx="14" cy="38" r="3"/><circle cx="34" cy="38" r="3"/>
                    <path d="M11 29.5h3M34 29.5h3"/>
                </svg>
                <div>
                    <h3>Wide Selection</h3>
                    <p>Quality cars from trusted sources</p>
                </div>
            </div>

            <div class="footer-feature">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M24 6 9 12v11c0 9.5 6.4 16.4 15 19 8.6-2.6 15-9.5 15-19V12L24 6Z"/>
                    <path d="m17 24 5 5 9-10"/>
                </svg>
                <div>
                    <h3>Transparent Process</h3>
                    <p>Clear pricing and documentation</p>
                </div>
            </div>

            <div class="footer-feature">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 12h26v22H4z"/>
                    <path d="M30 20h8l6 7v7H30"/>
                    <circle cx="13" cy="36" r="3.5"/><circle cx="36" cy="36" r="3.5"/>
                    <path d="M9 18h12M9 24h8"/>
                </svg>
                <div>
                    <h3>Global Sourcing</h3>
                    <p>Japan, South Africa, Dubai</p>
                </div>
            </div>

            <div class="footer-feature">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 28v-5a15 15 0 0 1 30 0v5"/>
                    <rect x="6" y="26" width="7" height="12" rx="3"/>
                    <rect x="35" y="26" width="7" height="12" rx="3"/>
                    <path d="M39 38c0 3-3 5-8 5h-4"/>
                </svg>
                <div>
                    <h3>Ongoing Support</h3>
                    <p>Before, during and after delivery</p>
                </div>
            </div>
        </div>

        <div class="footer-year">
            © {{ date('Y') }} WeSellGaris. All rights reserved.
            <a href="https://www.galaxiescoders.com/"
               class="footer-dev-link"
               target="_blank">

                Developed and maintained by Galaxies Coders
            </a>
        </div>

    </div>
</footer>
