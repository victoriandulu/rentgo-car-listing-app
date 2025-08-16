@extends('layouts.app')

@section('content')
<div>
    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="hero-content">
            <h1>
                Frequently Asked
                <span class="subtitle-highlight">Questions</span>
            </h1>
            <p>Everything you need to know about our premium vehicle services and exceptional customer experience</p>
        </div>
        <div class="decorative-circle"></div>
    </div>

    {{-- FAQ Container --}}
    <div class="faq-container">
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
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ({{ $index }})">
                    <span class="question-text">{{ $faq[0] }}</span>
                    <div class="toggle-icon" id="icon-{{ $index }}">+</div>
                </div>
                <div class="faq-answer" id="answer-{{ $index }}" style="display: none;">
                    <div class="faq-answer-content">
                        <div class="faq-answer-inner">
                            <p>{{ $faq[1] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Contact Section --}}
        <div class="faq-footer">
            <div class="contact-card">
                <div class="contact-content">
                    <h2>Still Have Questions?</h2>
                    <p>Our expert team is here to help you find the perfect vehicle solution</p>
                    <a href="tel:+254720063956" class="contact-button">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        Call Our Support Team
                    </a>
                </div>
                <div class="contact-decoration"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFAQ(index) {
        const answer = document.getElementById('answer-' + index);
        const icon = document.getElementById('icon-' + index);

        if (answer.style.display === 'none') {
            answer.style.display = 'block';
            icon.innerHTML = '−';
        } else {
            answer.style.display = 'none';
            icon.innerHTML = '+';
        }
    }
</script>

<style>
/* Beautiful FAQ Styles using RENT=GO brand colors */

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f5f7fa 0%, #fff5f5 50%, #fef7e0 100%);
  min-height: 100vh;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #facc15 100%);
  padding: 80px 20px;
  text-align: center;
  position: relative;
  overflow: hidden;
  margin-bottom: 60px;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.1);
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  margin: 0 auto;
}

.hero-section h1 {
  font-size: 4rem;
  font-weight: 700;
  color: white;
  margin-bottom: 20px;
  line-height: 1.1;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-section .subtitle-highlight {
  color: white;
  display: block;
}

.hero-section p {
  font-size: 1.3rem;
  color: white;
  opacity: 0.95;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Decorative elements */
.hero-section::after {
  content: '';
  position: absolute;
  top: 20px;
  left: 20px;
  width: 80px;
  height: 80px;
  background: #facc15;
  border-radius: 50%;
  opacity: 0.3;
  animation: pulse 3s infinite;
}

.decorative-circle {
  position: absolute;
  bottom: 20px;
  right: 20px;
  width: 120px;
  height: 120px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  animation: bounce 2s infinite;
}

/* Main FAQ Container */
.faq-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 30px 60px;
}

.faq-list {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* FAQ Items */
.faq-item {
  background: white;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border-left: 6px solid transparent;
  position: relative;
}

.faq-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
  border-left-color: #facc15;
}

.faq-item.active {
  border-left-color: #dc2626;
  transform: translateY(-2px);
  box-shadow: 0 16px 32px rgba(220, 38, 38, 0.15);
}

/* FAQ Question */
.faq-question {
  padding: 32px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: all 0.3s ease;
  background: white;
  position: relative;
}

.faq-question:hover {
  background: linear-gradient(135deg, #fef7e0 0%, #fff5f5 100%);
}

.faq-item.active .faq-question {
  background: linear-gradient(135deg, #fef2f2 0%, #fef7e0 100%);
}

.question-text {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  line-height: 1.4;
  transition: color 0.3s ease;
  flex: 1;
}

.faq-item.active .question-text {
  color: #dc2626;
}

.faq-item:hover .question-text {
  color: #dc2626;
}

/* Toggle Icon */
.toggle-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #facc15;
  color: #dc2626;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: bold;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  margin-left: 24px;
  flex-shrink: 0;
}

.faq-item:hover .toggle-icon {
  background: #dc2626;
  color: white;
  transform: scale(1.1);
}

.faq-item.active .toggle-icon {
  background: #dc2626;
  color: white;
  transform: rotate(45deg) scale(1.1);
}

/* FAQ Answer */
.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
}

.faq-item.active .faq-answer {
  max-height: 500px;
  opacity: 1;
}

.faq-answer-content {
  padding: 0 32px 32px;
}

.faq-answer-inner {
  background: linear-gradient(135deg, #fef2f2 0%, #fef7e0 100%);
  padding: 24px;
  border-radius: 16px;
  border-left: 4px solid #dc2626;
  position: relative;
}

.faq-answer p {
  color: #374151;
  font-size: 1.1rem;
  line-height: 1.7;
  margin: 0;
}

/* Contact Section */
.faq-footer {
  margin-top: 80px;
  text-align: center;
}

.contact-card {
  background: linear-gradient(135deg, #dc2626 0%, #facc15 100%);
  padding: 60px 40px;
  border-radius: 24px;
  color: white;
  position: relative;
  overflow: hidden;
}

.contact-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.1);
  z-index: 1;
}

.contact-content {
  position: relative;
  z-index: 2;
}

.contact-card h2 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 16px;
  color: white;
}

.contact-card p {
  font-size: 1.2rem;
  margin-bottom: 32px;
  opacity: 0.95;
}

.contact-button {
  display: inline-flex;
  align-items: center;
  padding: 16px 32px;
  background: white;
  color: #dc2626;
  text-decoration: none;
  font-weight: 700;
  font-size: 1.1rem;
  border-radius: 50px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.contact-button:hover {
  background: #fef7e0;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.contact-button svg {
  width: 24px;
  height: 24px;
  margin-right: 12px;
}

/* Contact card decorative elements */
.contact-card::after {
  content: '';
  position: absolute;
  top: -20px;
  right: -20px;
  width: 100px;
  height: 100px;
  background: #facc15;
  border-radius: 50%;
  opacity: 0.3;
  z-index: 1;
}

.contact-decoration {
  position: absolute;
  bottom: -20px;
  left: -20px;
  width: 140px;
  height: 140px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  z-index: 1;
}

/* Animations */
@keyframes pulse {
  0%, 100% {
    opacity: 0.3;
    transform: scale(1);
  }
  50% {
    opacity: 0.5;
    transform: scale(1.1);
  }
}

@keyframes bounce {
  0%, 20%, 53%, 80%, 100% {
    transform: translate3d(0,0,0);
  }
  40%, 43% {
    transform: translate3d(0, -8px, 0);
  }
  70% {
    transform: translate3d(0, -4px, 0);
  }
  90% {
    transform: translate3d(0, -2px, 0);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-section {
    padding: 60px 20px;
  }

  .hero-section h1 {
    font-size: 2.5rem;
  }

  .hero-section p {
    font-size: 1.1rem;
  }

  .faq-container {
    padding: 0 20px 40px;
  }

  .faq-question {
    padding: 24px 20px;
  }

  .question-text {
    font-size: 1.1rem;
  }

  .toggle-icon {
    width: 40px;
    height: 40px;
    margin-left: 16px;
  }

  .faq-answer-content {
    padding: 0 20px 24px;
  }

  .contact-card {
    padding: 40px 24px;
  }

  .contact-card h2 {
    font-size: 2rem;
  }

  .contact-button {
    padding: 14px 28px;
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .hero-section h1 {
    font-size: 2rem;
  }

  .faq-question {
    padding: 20px 16px;
  }

  .question-text {
    font-size: 1rem;
  }

  .toggle-icon {
    width: 36px;
    height: 36px;
    font-size: 1.2rem;
  }
}
</style>
@endsection
