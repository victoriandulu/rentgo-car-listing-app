@extends('layouts.app')

@section('content')
<div class="sell-car-container">
    <div class="sell-car-hero">
        <div class="hero-content">
            <h1>Sell Your Car With Confidence</h1>
            <p>Join thousands of satisfied sellers who found the perfect buyers on our platform</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Cars Sold</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">4.8</span>
                    <span class="stat-label">User Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">7 Days</span>
                    <span class="stat-label">Avg. Selling Time</span>
                </div>
            </div>
        </div>
        <div class="car-illustration"></div>
    </div>

    <div class="signup-section">
        <div class="signup-container">
            {{-- Tabs --}}
            <div class="tabs">
                <button class="tab active">Sign Up</button>
                <button class="tab">Log In</button>
            </div>

            {{-- Google Signup/Login (placeholder) --}}
            <div class="social-signup">
                <button class="google-btn">
                    <span class="google-icon"></span>
                    Sign up with Google
                </button>
            </div>

            <div class="divider">
                <span>or</span>
            </div>

            {{-- Signup Form --}}
            <form method="POST" action="{{ route('sell.store') }}" class="signup-form">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" value="{{ old('firstName') }}">
                        @error('firstName') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" value="{{ old('lastName') }}">
                        @error('lastName') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    @error('password') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation">
                </div>

                <button type="submit" class="submit-button">Sign Up & Sell Your Car</button>
            </form>

            {{-- Switch to login --}}
            <div class="form-footer">
                <p>Already have an account? <a href="#">Log In</a></p>
            </div>
        </div>

        {{-- Benefits Sidebar --}}
        <div class="benefits-sidebar">
            <h3>Why Sell With Us?</h3>
            <ul class="benefits-list">
                <li><span class="benefit-icon check"></span> Free basic listings with no hidden fees</li>
                <li><span class="benefit-icon money"></span> Get up to 15% more than dealer trade-in value</li>
                <li><span class="benefit-icon shield"></span> Verified buyers and secure payment process</li>
                <li><span class="benefit-icon chart"></span> Market analysis tools to price your car right</li>
                <li><span class="benefit-icon star"></span> Premium listing options for faster selling</li>
            </ul>

            <div class="testimonial">
                <p>"I sold my BMW in just 3 days for 3.5m more than the dealership offered!"</p>
                <div class="user-info">
                    <div class="avatar"></div>
                    <div>
                        <strong>Michael T.</strong>
                        <div class="rating">★★★★★</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Leave CSS empty so you can add styles --}}
<style>
/* RENT=GO Sell Your Car Page - Enhanced Design */

:root {
  --rentgo-red: #e53e3e;
  --rentgo-yellow: #ffd700;
  --rentgo-dark: #4a5568;
  --rentgo-light-red: #fed7d7;
  --rentgo-light-yellow: #fffacd;
  --shadow-soft: 0 10px 30px rgba(229, 62, 62, 0.1);
  --shadow-strong: 0 20px 40px rgba(229, 62, 62, 0.15);
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sell-car-container {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  color: var(--rentgo-dark);
  max-width: 1400px;
  margin: 0 auto;
}

/* Hero Section */
.sell-car-hero {
  display: flex;
  align-items: center;
  padding: 80px 40px;
  background: linear-gradient(135deg, var(--rentgo-light-red) 0%, var(--rentgo-light-yellow) 100%);
  border-radius: 0 0 50px 50px;
  position: relative;
  overflow: hidden;
}

.sell-car-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill-opacity='0.03' fill='%23e53e3e'%3E%3Cpolygon points='30,0 60,30 30,60 0,30'/%3E%3C/g%3E%3C/svg%3E") center/60px;
}

.hero-content {
  flex: 1;
  max-width: 600px;
  z-index: 2;
}

.hero-content h1 {
  font-size: clamp(36px, 5vw, 48px);
  font-weight: 800;
  margin-bottom: 20px;
  color: var(--rentgo-red);
  line-height: 1.2;
  text-shadow: 0 2px 4px rgba(229, 62, 62, 0.1);
}

.hero-content p {
  font-size: 18px;
  line-height: 1.6;
  color: var(--rentgo-dark);
  margin-bottom: 40px;
  opacity: 0.9;
}

.hero-stats {
  display: flex;
  gap: 40px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  padding: 20px;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 20px;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(229, 62, 62, 0.1);
}

.stat-number {
  font-size: 32px;
  font-weight: 700;
  color: var(--rentgo-red);
  text-shadow: 0 2px 4px rgba(229, 62, 62, 0.1);
}

.stat-label {
  font-size: 14px;
  color: var(--rentgo-dark);
  opacity: 0.8;
}

.car-illustration {
  flex: 1;
  height: 400px;
  background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
  border-radius: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.car-illustration::after {
  content: '🚗';
  font-size: 120px;
  opacity: 0.3;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

/* Main Content Layout */
.signup-section {
  display: flex;
  gap: 40px;
  padding: 60px 40px;
}

/* Form Container */
.signup-container, .car-listing-container {
  background: white;
  border-radius: 30px;
  box-shadow: var(--shadow-strong);
  padding: 40px;
  border: 1px solid rgba(229, 62, 62, 0.05);
}

.signup-container {
  flex: 2;
  max-width: 600px;
}

.car-listing-container {
  max-width: 800px;
  margin: 40px auto;
}

/* Tabs */
.tabs {
  display: flex;
  margin-bottom: 30px;
  background: var(--rentgo-light-red);
  border-radius: 20px;
  padding: 4px;
}

.tab {
  flex: 1;
  background: none;
  border: none;
  padding: 16px 20px;
  font-size: 16px;
  font-weight: 600;
  color: var(--rentgo-dark);
  cursor: pointer;
  border-radius: 16px;
  transition: var(--transition);
}

.tab.active {
  background: var(--rentgo-red);
  color: white;
  box-shadow: var(--shadow-soft);
}

/* Buttons */
.google-btn, .submit-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 16px;
  border-radius: 20px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  border: none;
}

.google-btn {
  background: white;
  color: var(--rentgo-dark);
  border: 2px solid var(--rentgo-light-red);
  margin-bottom: 30px;
}

.google-btn:hover {
  background: var(--rentgo-light-red);
  border-color: var(--rentgo-red);
  transform: translateY(-2px);
  box-shadow: var(--shadow-soft);
}

.submit-button {
  background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
  color: white;
  margin-top: 20px;
  box-shadow: var(--shadow-soft);
}

.submit-button:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-strong);
}

.google-icon {
  width: 20px;
  height: 20px;
  margin-right: 12px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48'%3E%3Cpath fill='%23FFC107' d='M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z'/%3E%3Cpath fill='%23FF3D00' d='M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z'/%3E%3Cpath fill='%234CAF50' d='M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z'/%3E%3Cpath fill='%231976D2' d='M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z'/%3E%3C/svg%3E");
  background-size: contain;
}

/* Divider */
.divider {
  position: relative;
  text-align: center;
  margin: 30px 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--rentgo-light-red), transparent);
}

.divider span {
  background: white;
  padding: 0 20px;
  color: var(--rentgo-dark);
  font-weight: 500;
}

/* Form Elements */
.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.form-row .form-group {
  flex: 1;
}

.form-group {
  margin-bottom: 25px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--rentgo-dark);
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

input {
  width: 100%;
  padding: 16px 20px;
  border: 2px solid var(--rentgo-light-red);
  border-radius: 15px;
  font-size: 16px;
  transition: var(--transition);
  background: rgba(255, 255, 255, 0.8);
}

input:focus {
  outline: none;
  border-color: var(--rentgo-red);
  box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.1);
  background: white;
}

input.error {
  border-color: var(--rentgo-red);
  background: var(--rentgo-light-red);
}

.error-message {
  color: var(--rentgo-red);
  font-size: 14px;
  margin-top: 8px;
  font-weight: 500;
}

.password-input-container {
  position: relative;
}

.toggle-password {
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  padding: 8px;
  border-radius: 8px;
  transition: var(--transition);
}

.toggle-password:hover {
  background: var(--rentgo-light-red);
}

.text-button {
  background: none;
  border: none;
  color: var(--rentgo-red);
  cursor: pointer;
  font-weight: 600;
  transition: var(--transition);
}

.text-button:hover {
  color: var(--rentgo-yellow);
  text-decoration: underline;
}

.form-footer {
  margin-top: 30px;
  text-align: center;
  color: var(--rentgo-dark);
}

/* Benefits Sidebar */
.benefits-sidebar {
  flex: 1;
  padding: 40px;
  background: linear-gradient(135deg, var(--rentgo-light-yellow) 0%, var(--rentgo-light-red) 100%);
  border-radius: 30px;
  display: flex;
  flex-direction: column;
  border: 1px solid rgba(255, 215, 0, 0.2);
}

.benefits-sidebar h3 {
  font-size: 28px;
  font-weight: 800;
  margin-bottom: 30px;
  color: var(--rentgo-red);
  text-align: center;
}

.benefits-list {
  list-style: none;
  padding: 0;
  margin: 0 0 40px 0;
}

.benefits-list li {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  font-size: 16px;
  color: var(--rentgo-dark);
  padding: 15px;
  background: rgba(255, 255, 255, 0.6);
  border-radius: 15px;
  transition: var(--transition);
}

.benefits-list li:hover {
  background: rgba(255, 255, 255, 0.9);
  transform: translateX(5px);
}

.benefit-icon {
  width: 40px;
  height: 40px;
  margin-right: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: var(--rentgo-red);
  color: white;
  font-size: 18px;
  font-weight: bold;
}

.benefit-icon.check::before { content: "✓"; }
.benefit-icon.money::before { content: "$"; }
.benefit-icon.shield::before { content: "🛡️"; }
.benefit-icon.chart::before { content: "📊"; }
.benefit-icon.star::before { content: "⭐"; }

/* Testimonial */
.testimonial {
  background: white;
  padding: 30px;
  border-radius: 20px;
  box-shadow: var(--shadow-soft);
  margin-top: auto;
  border: 1px solid rgba(229, 62, 62, 0.1);
}

.testimonial p {
  font-style: italic;
  margin-bottom: 20px;
  color: var(--rentgo-dark);
  line-height: 1.6;
}

.user-info {
  display: flex;
  align-items: center;
}

.avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--rentgo-red), var(--rentgo-yellow));
  margin-right: 15px;
}

.rating {
  color: var(--rentgo-yellow);
  font-size: 16px;
  font-weight: bold;
}

/* Car Listing Specific */
.car-listing-container h1 {
  font-size: 32px;
  font-weight: 800;
  margin-bottom: 20px;
  color: var(--rentgo-red);
}

.success-message {
  background: var(--rentgo-light-yellow);
  color: var(--rentgo-red);
  padding: 20px;
  border-radius: 15px;
  margin-bottom: 30px;
  border: 2px solid var(--rentgo-yellow);
  font-weight: 600;
}

.listing-steps {
  display: flex;
  justify-content: space-between;
  margin-bottom: 40px;
}

.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  color: var(--rentgo-dark);
  opacity: 0.5;
  position: relative;
  flex: 1;
  transition: var(--transition);
}

.step.active {
  opacity: 1;
  color: var(--rentgo-red);
}

.step-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--rentgo-light-red);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  margin-bottom: 10px;
  transition: var(--transition);
}

.step.active .step-number {
  background: var(--rentgo-red);
  color: white;
  box-shadow: var(--shadow-soft);
}

.form-placeholder {
  padding: 60px 40px;
  border: 3px dashed var(--rentgo-light-red);
  border-radius: 20px;
  text-align: center;
  color: var(--rentgo-dark);
  opacity: 0.7;
}

/* Responsive Design */
@media (max-width: 992px) {
  .sell-car-hero {
    flex-direction: column;
    padding: 60px 30px;
    text-align: center;
  }

  .hero-content {
    margin-bottom: 40px;
  }

  .hero-stats {
    justify-content: center;
    flex-wrap: wrap;
  }

  .signup-section {
    flex-direction: column;
    padding: 40px 20px;
  }

  .form-row {
    flex-direction: column;
  }
}

@media (max-width: 576px) {
  .hero-stats {
    flex-direction: column;
    gap: 20px;
    align-items: center;
  }

  .signup-container, .benefits-sidebar, .car-listing-container {
    padding: 25px 20px;
  }

  .listing-steps {
    flex-direction: column;
    gap: 20px;
  }
}
</style>
@endsection
