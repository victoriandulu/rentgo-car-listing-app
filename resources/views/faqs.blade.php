@extends('layouts.app')

@section('content')
<div>
    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-content">
            <h1>
                Frequently Asked
                <span class="subtitle-highlight">Questions</span>
            </h1>
            <p>
                Everything you need to know about our premium vehicle services and exceptional customer experience.
            </p>
        </div>
        <div class="decorative-circle"></div>
    </section>

    {{-- FAQ Section --}}
    <section class="faq-container">
        <div class="faq-list">
            @php
                $faqs = [
                    ["Do you offer both new and pre-owned vehicles?", "Yes, we provide a selection of both brand-new and certified used cars to meet diverse customer needs."],
                    ["What are the origins of your imported vehicles?", "Our cars are sourced from reputable suppliers and dealerships across the globe, ensuring a wide variety and high quality in our offerings."],
                    ["Are financing options available for car purchases?", "We accommodate both cash payments and bank-assisted asset financing. Currently, we do not provide hire purchase arrangements."],
                    ["Is it possible to trade in my existing vehicle for another?", "Yes, we facilitate trade-ins and offer fair market value assessments to ensure a smooth transition to your next vehicle."],
                    ["What does your warranty cover?", "Our comprehensive warranty covers mechanical and electrical components for 12 months or 20,000 kilometers, whichever comes first. This includes engine, transmission, steering, and braking systems."],
                    ["How long does the import process typically take?", "The import process usually takes 4-6 weeks from order confirmation to delivery. Custom orders or specialty vehicles may require additional time. We provide regular updates throughout the process."],
                    ["Do you offer vehicle customization services?", "Yes, we provide a range of customization options including interior upgrades, performance enhancements, and exterior modifications. Our specialists can help create a vehicle tailored to your specific preferences."],
                    ["What documentation is required for purchasing a vehicle?", "You'll need a valid ID (passport or national ID), proof of address, and tax compliance certificate. For financing, additional documentation from your bank may be required."],
                    ["Do you offer after-sales service and maintenance?", "Absolutely! We have a state-of-the-art service center with certified technicians for all maintenance and repair needs. We also offer service packages that can be included with your purchase."],
                    ["Can I test drive vehicles before making a decision?", "Yes, we encourage test drives to ensure your complete satisfaction. Simply book an appointment online or call us to arrange a test drive of any vehicle in our inventory."],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="faq-item" onclick="toggleFAQ({{ $index }})">
                <div class="faq-question">
                    <span class="question-text">{{ $faq[0] }}</span>
                    <button class="toggle-btn" id="icon-{{ $index }}" aria-label="Toggle FAQ">+</button>
                </div>
                <div class="faq-answer" id="answer-{{ $index }}">
                    <p>{{ $faq[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Contact Section --}}
        <div class="faq-footer">
            <div class="contact-card">
                <div class="contact-content">
                    <h2>Still Have Questions?</h2>
                    <p>Our expert team is here to help you find the perfect vehicle solution.</p>
                    <a href="tel:+254720063956" class="contact-button">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        Call Our Support Team
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleFAQ(index) {
        const item = document.querySelectorAll('.faq-item')[index];
        const answer = document.getElementById('answer-' + index);
        const icon = document.getElementById('icon-' + index);

        const isActive = item.classList.contains('active');

        // Close all
        document.querySelectorAll('.faq-item').forEach(i => {
            i.classList.remove('active');
            i.querySelector('.faq-answer').style.maxHeight = null;
            i.querySelector('.toggle-btn').innerHTML = '+';
        });

        // Toggle selected
        if (!isActive) {
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.innerHTML = '−';
        }
    }
</script>

<style>
/* === GENERAL === */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  background: #fff;
}

/* === HERO SECTION === */
.hero-section {
  background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #facc15 100%);
  padding: 80px 20px;
  text-align: center;
  color: white;
  position: relative;
  overflow: hidden;
}

.hero-section h1 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 1rem;
}

.hero-section .subtitle-highlight {
  display: inline-block;
  color: #fff;
  text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
}

.hero-section p {
  font-size: 1.2rem;
  opacity: 0.95;
  max-width: 700px;
  margin: 0 auto;
}

.decorative-circle {
  position: absolute;
  bottom: 20px;
  right: 30px;
  width: 100px;
  height: 100px;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 50%;
  animation: float 4s ease-in-out infinite;
}

/* === FAQ CONTAINER === */
.faq-container {
  max-width: 900px;
  margin: 60px auto;
  padding: 0 20px;
}

.faq-item {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  margin-bottom: 20px;
  transition: all 0.3s ease;
  overflow: hidden;
  border-left: 6px solid transparent;
}

.faq-item.active {
  border-left-color: #dc2626;
  transform: translateY(-2px);
}

.faq-question {
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-weight: 600;
  color: #1f2937;
  transition: color 0.3s ease;
}

.faq-item:hover .faq-question {
  color: #dc2626;
}

.toggle-btn {
  background: #facc15;
  border: none;
  color: #dc2626;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 1.4rem;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s ease;
}

.faq-item.active .toggle-btn {
  background: #dc2626;
  color: #fff;
  transform: rotate(180deg);
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s ease;
  background: linear-gradient(135deg, #fff5f5 0%, #fffbea 100%);
}

.faq-answer p {
  padding: 0 24px 24px;
  font-size: 1.05rem;
  color: #374151;
  line-height: 1.6;
}

/* === CONTACT SECTION === */
.faq-footer {
  margin-top: 80px;
  text-align: center;
}

.contact-card {
  background: linear-gradient(135deg, #dc2626 0%, #facc15 100%);
  padding: 60px 40px;
  border-radius: 20px;
  color: white;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.contact-card h2 {
  font-size: 2.2rem;
  margin-bottom: 1rem;
}

.contact-card p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.contact-button {
  display: inline-flex;
  align-items: center;
  background: #fff;
  color: #dc2626;
  padding: 14px 28px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.contact-button:hover {
  background: #fef7e0;
  transform: translateY(-2px);
}

.contact-button svg {
  width: 22px;
  height: 22px;
  margin-right: 10px;
}

/* === ANIMATIONS === */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
  .hero-section h1 { font-size: 2.2rem; }
  .faq-question { padding: 20px; }
  .toggle-btn { width: 36px; height: 36px; }
  .contact-card { padding: 40px 24px; }
  .contact-card h2 { font-size: 1.8rem; }
}
</style>
@endsection
