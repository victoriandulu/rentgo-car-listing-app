@extends('layouts.app')

@section('content')
<div class="contact-us-container">
    <div class="contact-header">
        <div class="header-content">
            <h1>Contact Us</h1>
            <div class="header-underline"></div>
            <p>We're here to help with all your luxury car rental needs</p>
        </div>
    </div>

    <div class="contact-content">
        <!-- Contact Info -->
        <div class="contact-info">
            <div class="info-card">
                <div class="info-icon"><i class="phone-icon"></i></div>
                <h3>Call Us</h3>
                <p>+254-717-475-336</p>
                <p class="hours">Mon-Fri: 9AM-6PM</p>
            </div>

            <div class="info-card">
                <div class="info-icon"><i class="email-icon"></i></div>
                <h3>Email Us</h3>
                <p>rentgo@gmail.com</p>
                <p class="hours">We respond within 24 hours</p>
            </div>

            <div class="info-card">
                <div class="info-icon"><i class="location-icon"></i></div>
                <h3>Visit Us</h3>
                <p>Kenya Railways Station</p>
                <p class="hours">Nairobi, Kenya</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-container">
            @if(session('success'))
                <div class="success-message">
                    <h2>Thank You!</h2>
                    <p>{{ session('success') }}</p>
                    <a href="{{ route('contact') }}" class="send-new-message">Send Another Message</a>
                </div>
            @else
                <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <h2>Send us a message</h2>

                    <div class="form-group">
                        <label for="name">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your full name" class="@error('name') error @enderror">
                        @error('name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="your.email@example.com" class="@error('email') error @enderror">
                            @error('email') <div class="error-message">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number (Optional)</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+254 XXX XXX XXX" class="@error('phone') error @enderror">
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select name="subject" id="subject">
                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Car Rental" {{ old('subject') == 'Car Rental' ? 'selected' : '' }}>Car Rental</option>
                            <option value="Luxury Fleet" {{ old('subject') == 'Luxury Fleet' ? 'selected' : '' }}>Luxury Fleet</option>
                            <option value="Corporate Rentals" {{ old('subject') == 'Corporate Rentals' ? 'selected' : '' }}>Corporate Rentals</option>
                            <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea name="message" id="message" rows="5" placeholder="Tell us how we can help you..." class="@error('message') error @enderror">{{ old('message') }}</textarea>
                        @error('message') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="submit-button">Send Message</button>
                </form>
            @endif
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <div class="faq-header">
            <h2>Frequently Asked Questions</h2>
            <p class="faq-subtitle">Quick answers to common questions</p>
            <div class="faq-underline"></div>
        </div>

        <div class="faq-grid">
            <div class="faq-item">
                <h3>How do I book a luxury car?</h3>
                <p>Simply browse our premium fleet, select your preferred vehicle, choose your rental dates, and complete the booking process online. It's that easy!</p>
            </div>
            <div class="faq-item">
                <h3>What documents do I need?</h3>
                <p>You'll need a valid driver's license, passport or national ID, and a credit card for security deposit. International visitors may need an International Driving Permit.</p>
            </div>
            <div class="faq-item">
                <h3>Do you offer delivery service?</h3>
                <p>Yes! We provide complimentary delivery and pickup within Nairobi CBD. Extended delivery areas are available for an additional fee.</p>
            </div>
        </div>
    </div>
</div>

<!-- Leave empty for your CSS -->
<style>

.contact-us-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  color: #333;
  background: #fff;
  overflow-x: hidden;
}

/* Header Section */
.contact-header {
  text-align: center;
  padding: 80px 0 60px;
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  margin: 0 -20px 60px -20px;
  position: relative;
  overflow: hidden;
}

.contact-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, rgba(255, 0, 0, 0.05), rgba(255, 215, 0, 0.05));
  z-index: 1;
}

.header-content {
  position: relative;
  z-index: 2;
}

.contact-header h1 {
  font-size: 4rem;
  font-weight: 800;
  margin-bottom: 20px;
  color: #333;
  background: linear-gradient(45deg, #FF0000, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.contact-header p {
  font-size: 1.3rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
  font-weight: 300;
}

.header-underline {
  width: 100px;
  height: 5px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
  margin: 20px auto 0;
  border-radius: 3px;
  box-shadow: 0 2px 10px rgba(255, 0, 0, 0.3);
}

/* Contact Content Layout */
.contact-content {
  display: flex;
  gap: 50px;
  margin-bottom: 100px;
  align-items: stretch;
}

/* Contact Info Cards */
.contact-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.info-card {
  background: white;
  border-radius: 20px;
  padding: 35px 30px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 3px solid transparent;
  position: relative;
  overflow: hidden;
}

.info-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
}

.info-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  border-color: #FFD700;
}

.info-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: linear-gradient(135deg, #FF0000, #FFD700);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  box-shadow: 0 10px 25px rgba(255, 0, 0, 0.3);
}

.info-icon i {
  font-size: 1.8rem;
  color: white;
}

.info-card h3 {
  font-size: 1.6rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: #333;
}

.info-card p {
  margin: 8px 0;
  color: #555;
  font-size: 1.1rem;
}

.info-card .hours {
  font-size: 1rem;
  color: #777;
  font-style: italic;
}

.phone-icon::before { content: "📞"; font-size: 1.5rem; }
.email-icon::before { content: "✉️"; font-size: 1.5rem; }
.location-icon::before { content: "📍"; font-size: 1.5rem; }

/* Contact Form */
.contact-form-container {
  flex: 1.5;
  background: white;
  border-radius: 25px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
  padding: 50px 40px;
  position: relative;
  overflow: hidden;
}

.contact-form-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
}

.contact-form h2 {
  font-size: 2.2rem;
  font-weight: 700;
  margin-bottom: 35px;
  color: #333;
  text-align: center;
}

.form-group {
  margin-bottom: 25px;
}

.form-row {
  display: flex;
  gap: 25px;
  margin-bottom: 25px;
}

.form-row .form-group {
  flex: 1;
  margin-bottom: 0;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
  color: #333;
  font-size: 1rem;
}

.required {
  color: #FF0000;
  font-weight: 700;
}

input, select, textarea {
  width: 100%;
  padding: 15px 20px;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  font-family: inherit;
  background: #fafafa;
  box-sizing: border-box;
}

input:focus, select:focus, textarea:focus {
  outline: none;
  border-color: #FFD700;
  background: white;
  box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.2);
  transform: translateY(-2px);
}

input.error, select.error, textarea.error {
  border-color: #FF0000;
  background: rgba(255, 0, 0, 0.05);
}

.error-message {
  color: #FF0000;
  font-size: 0.9rem;
  margin-top: 8px;
  font-weight: 500;
}

textarea {
  resize: vertical;
  min-height: 130px;
  font-family: inherit;
}

.submit-button {
  background: linear-gradient(135deg, #FF0000, #FFD700);
  color: white;
  border: none;
  border-radius: 50px;
  padding: 18px 40px;
  font-size: 1.2rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 100%;
  box-shadow: 0 10px 25px rgba(255, 0, 0, 0.3);
  position: relative;
  overflow: hidden;
}

.submit-button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: left 0.5s ease;
}

.submit-button:hover::before {
  left: 100%;
}

.submit-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 35px rgba(255, 0, 0, 0.4);
}

/* Success Message */
.success-message {
  text-align: center;
  padding: 60px 40px;
}

.success-icon {
  width: 100px;
  height: 100px;
  background: linear-gradient(135deg, #FF0000, #FFD700);
  border-radius: 50%;
  margin: 0 auto 30px;
  position: relative;
  box-shadow: 0 15px 30px rgba(255, 0, 0, 0.3);
  animation: successPulse 2s ease-in-out infinite;
}

@keyframes successPulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.1); }
}

.success-icon::before {
  content: "✓";
  font-size: 3rem;
  color: white;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-weight: bold;
}

.success-message h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333;
  font-weight: 700;
}

.success-message p {
  color: #666;
  margin-bottom: 30px;
  font-size: 1.2rem;
}

.send-new-message {
  background: linear-gradient(135deg, #f8f9fa, #e2e8f0);
  border: 2px solid #FFD700;
  border-radius: 50px;
  padding: 15px 30px;
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  cursor: pointer;
  transition: all 0.3s ease;
}

.send-new-message:hover {
  background: linear-gradient(135deg, #FFD700, #FF0000);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(255, 215, 0, 0.3);
}

/* FAQ Section */
.faq-section {
  padding: 60px 0;
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  margin: 0 -20px;
  border-radius: 30px 30px 0 0;
}

.faq-header {
  text-align: center;
  margin-bottom: 50px;
  padding: 0 20px;
}

.faq-section h2 {
  font-size: 3rem;
  margin-bottom: 20px;
  color: #333;
  font-weight: 700;
  background: linear-gradient(45deg, #FF0000, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.faq-subtitle {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 20px;
}

.faq-underline {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
  margin: 0 auto;
  border-radius: 2px;
}

.faq-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 30px;
  padding: 0 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.faq-item {
  background: white;
  border-radius: 20px;
  padding: 35px 30px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border: 3px solid transparent;
  position: relative;
  overflow: hidden;
}

.faq-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
}

.faq-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
  border-color: #FFD700;
}

.faq-item h3 {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: #333;
}

.faq-item p {
  color: #555;
  line-height: 1.7;
  font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 992px) {
  .contact-content {
    flex-direction: column;
    gap: 40px;
  }

  .contact-header h1 {
    font-size: 3rem;
  }

  .faq-section h2 {
    font-size: 2.5rem;
  }
}

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
    gap: 25px;
  }

  .contact-header h1 {
    font-size: 2.5rem;
  }

  .contact-form-container {
    padding: 40px 30px;
  }

  .faq-grid {
    grid-template-columns: 1fr;
    gap: 25px;
  }
}

@media (max-width: 600px) {
  .contact-header {
    padding: 60px 0 40px;
  }

  .contact-header h1 {
    font-size: 2.2rem;
  }

  .contact-form-container {
    padding: 35px 25px;
  }

  .info-card, .faq-item {
    padding: 25px 20px;
  }
}

</style>
@endsection
