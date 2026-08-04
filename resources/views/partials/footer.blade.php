<style>
.smart-footer {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    color: #e5e7eb;
    padding: 32px 20px;
    border-top: 3px solid #ef4444;
    margin-top: 60px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
}

.footer-brand {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 12px;
    letter-spacing: 0.5px;
}

.footer-divider {
    width: 60px;
    height: 2px;
    background: #ef4444;
    margin: 16px auto;
}

.footer-dev-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: #9ca3af;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 8px 16px;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.05);
}

.footer-dev-link:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
    transform: translateY(-2px);
}

.footer-dev-link svg {
    width: 16px;
    height: 16px;
}


</style>

<footer class="smart-footer">
    <div class="footer-content">


        <div class="footer-year">
            © {{ date('Y') }} WeSellGaris. All rights reserved.
            <a href="https://www.galaxiescoders.com/"
           class="footer-dev-link"
           target="_blank"
          >

            Developed and maintained by Galaxies Coders
        </a>
        </div>

        {{-- <div class="footer-divider"></div> --}}


    </div>
</footer>
