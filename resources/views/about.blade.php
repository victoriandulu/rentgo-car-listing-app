@extends('layouts.app') {{-- If you have a main layout --}}

@section('content')
<div class="about-container">
    <div class="about-hero">
        <div class="hero-content">
            <h1>About <span class="brand-highlight">RentGo</span></h1>
            <div class="hero-underline"></div>
            <p class="hero-subtitle">Luxury car rentals redefined</p>
        </div>
        <div class="hero-decoration">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
        </div>
    </div>

    {{-- Our Story --}}
    <section class="our-story">
        <div class="story-content">
            <div class="section-badge">Our Journey</div>
            <h2>The RentGo Story</h2>
            <p>
                Founded in 2018, RentGo began with a simple yet revolutionary idea: luxury car rentals should be accessible,
                convenient, and exceptional in every way. What started as a small collection of premium vehicles
                has grown into one of the region's most prestigious automotive rental services.
            </p>
            <p>
                We believe that driving is more than transportation—it's an experience that should ignite passion and create memories.
                Whether you're seeking the perfect vehicle for a special occasion, a business trip, or simply to enjoy
                the thrill of driving a luxury automobile, RentGo delivers unparalleled service and selection.
            </p>
            <div class="story-stats">
                <div class="stat-item">
                    <span class="stat-number">2018</span>
                    <span class="stat-label">Founded</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100+</span>
                    <span class="stat-label">Luxury Cars</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5000+</span>
                    <span class="stat-label">Happy Clients</span>
                </div>
            </div>
        </div>
        <div class="story-visual">
            <div class="story-image-container">
                <div class="image-placeholder">
                    <div class="car-icon">🚗</div>
                    <p>Premium Fleet</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Mission --}}
    <section class="our-mission">
        <div class="mission-header">
            <div class="section-badge">What Drives Us</div>
            <h2>Our Core Values</h2>
        </div>

        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon">
                    <span class="icon-symbol">★</span>
                </div>
                <h3>Excellence</h3>
                <p>
                    We provide exceptional automotive experiences through premium vehicles,
                    personalized service, and seamless rental processes that exceed expectations.
                </p>
            </div>

            <div class="mission-card">
                <div class="mission-icon">
                    <span class="icon-symbol">✓</span>
                </div>
                <h3>Integrity</h3>
                <p>
                    Excellence in every detail, integrity in all interactions, innovation in our offerings,
                    and genuine care for our customers' satisfaction and safety.
                </p>
            </div>

            <div class="mission-card">
                <div class="mission-icon">
                    <span class="icon-symbol">♦</span>
                </div>
                <h3>Quality Promise</h3>
                <p>
                    Each RentGo vehicle is meticulously maintained, thoroughly sanitized,
                    and delivered with comprehensive support for a worry-free experience.
                </p>
            </div>
        </div>
    </section>

    {{-- Achievements --}}
    <section class="achievements">
        <div class="achievements-header">
            <div class="section-badge">Our Impact</div>
            <h2>Achievements That Matter</h2>
            <p>Numbers that reflect our commitment to excellence</p>
        </div>

        <div class="achievement-grid">
            <div class="achievement-card">
                <div class="achievement-icon">🎯</div>
                <div class="achievement-number">5000+</div>
                <div class="achievement-text">Happy Customers</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-icon">🚘</div>
                <div class="achievement-number">100+</div>
                <div class="achievement-text">Luxury Vehicles</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-icon">⭐</div>
                <div class="achievement-number">4.9</div>
                <div class="achievement-text">Customer Rating</div>
            </div>
            <div class="achievement-card">
                <div class="achievement-icon">🕒</div>
                <div class="achievement-number">24/7</div>
                <div class="achievement-text">Customer Support</div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Experience RentGo?</h2>
            <p>Discover our premium fleet and book your dream car today.</p>
            <button class="cta-button">
                <span>Browse Our Fleet</span>
                <span class="button-arrow">→</span>
            </button>
        </div>
        <div class="cta-decoration">
            <div class="decoration-circle"></div>
            <div class="decoration-line"></div>
        </div>
    </section>
</div>

{{-- Add your CSS here --}}
<style>

.about-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
  background: #fff;
  overflow-x: hidden;
}

/* Hero Section */
.about-hero {
  position: relative;
  text-align: center;
  padding: 100px 0 80px;
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  margin: 0 -20px;
  overflow: hidden;
}

.hero-content {
  position: relative;
  z-index: 2;
}

.about-hero h1 {
  font-size: 4rem;
  margin: 0;
  letter-spacing: -1px;
  color: #333;
  font-weight: 800;
}

.brand-highlight {
  color: #FF0000;
  background: linear-gradient(45deg, #FF0000, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-underline {
  width: 120px;
  height: 6px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
  margin: 20px auto;
  border-radius: 3px;
  box-shadow: 0 2px 10px rgba(255, 0, 0, 0.3);
}

.hero-subtitle {
  font-size: 1.3rem;
  color: #666;
  margin-top: 20px;
  font-weight: 300;
}

.hero-decoration {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.floating-circle {
  position: absolute;
  border-radius: 50%;
  opacity: 0.1;
  animation: float 6s ease-in-out infinite;
}

.circle-1 {
  width: 100px;
  height: 100px;
  background: #FF0000;
  top: 20%;
  left: 10%;
  animation-delay: 0s;
}

.circle-2 {
  width: 150px;
  height: 150px;
  background: #FFD700;
  top: 60%;
  right: 15%;
  animation-delay: 2s;
}

.circle-3 {
  width: 80px;
  height: 80px;
  background: #FF0000;
  bottom: 20%;
  left: 20%;
  animation-delay: 4s;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

/* Section Badges */
.section-badge {
  display: inline-block;
  background: linear-gradient(45deg, #FF0000, #FFD700);
  color: white;
  padding: 8px 20px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 20px;
  box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
}

/* Our Story Section */
.our-story {
  display: flex;
  margin: 100px 0;
  gap: 60px;
  align-items: center;
}

.story-content {
  flex: 1.2;
}

.story-content h2 {
  font-size: 3rem;
  margin: 0 0 30px 0;
  color: #333;
  font-weight: 700;
  line-height: 1.2;
}

.story-content p {
  line-height: 1.8;
  font-size: 1.2rem;
  margin-bottom: 25px;
  color: #555;
}

.story-stats {
  display: flex;
  gap: 40px;
  margin-top: 40px;
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 2rem;
  font-weight: 800;
  color: #FF0000;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 0.9rem;
  color: #666;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.story-visual {
  flex: 1;
}

.story-image-container {
  background: linear-gradient(135deg, #FF0000, #FFD700);
  border-radius: 20px;
  padding: 60px;
  text-align: center;
  box-shadow: 0 20px 40px rgba(255, 0, 0, 0.2);
  transform: rotate(-2deg);
  transition: transform 0.3s ease;
}

.story-image-container:hover {
  transform: rotate(0deg) scale(1.05);
}

.image-placeholder {
  background: white;
  border-radius: 15px;
  padding: 40px;
  color: #333;
}

.car-icon {
  font-size: 4rem;
  margin-bottom: 20px;
}

.image-placeholder p {
  font-size: 1.3rem;
  font-weight: 600;
  margin: 0;
  color: #333;
}

/* Mission Section */
.our-mission {
  margin: 120px 0;
  text-align: center;
}

.mission-header h2 {
  font-size: 3rem;
  margin: 0 0 60px 0;
  color: #333;
  font-weight: 700;
}

.mission-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
  margin-top: 60px;
}

.mission-card {
  background: white;
  padding: 50px 30px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: all 0.3s ease;
  border: 3px solid transparent;
  position: relative;
  overflow: hidden;
}

.mission-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #FF0000, #FFD700);
}

.mission-card:hover {
  transform: translateY(-15px);
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  border-color: #FFD700;
}

.mission-icon {
  background: linear-gradient(135deg, #FF0000, #FFD700);
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 30px;
  box-shadow: 0 10px 25px rgba(255, 0, 0, 0.3);
}

.icon-symbol {
  color: white;
  font-size: 2rem;
  font-weight: bold;
}

.mission-card h3 {
  font-size: 1.8rem;
  margin: 0 0 20px;
  color: #333;
  font-weight: 700;
}

.mission-card p {
  line-height: 1.7;
  margin: 0;
  color: #555;
  font-size: 1.1rem;
}

/* Achievements Section */
.achievements {
  margin: 120px 0;
  text-align: center;
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  padding: 80px 40px;
  border-radius: 30px;
  position: relative;
}

.achievements-header h2 {
  font-size: 3rem;
  color: #333;
  margin: 0 0 20px 0;
  font-weight: 700;
}

.achievements-header p {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 60px;
}

.achievement-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 30px;
  max-width: 900px;
  margin: 0 auto;
}

.achievement-card {
  background: white;
  border-radius: 20px;
  padding: 40px 20px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 3px solid transparent;
}

.achievement-card:hover {
  transform: translateY(-10px);
  border-color: #FFD700;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.achievement-icon {
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.achievement-number {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 10px;
  background: linear-gradient(45deg, #FF0000, #FFD700);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.achievement-text {
  font-size: 1.1rem;
  color: #555;
  font-weight: 500;
}

/* CTA Section */
.cta-section {
  background: linear-gradient(135deg, #FF0000, #FFD700);
  border-radius: 25px;
  padding: 80px 40px;
  text-align: center;
  margin: 120px 0 60px;
  position: relative;
  overflow: hidden;
  color: white;
}

.cta-content {
  position: relative;
  z-index: 2;
}

.cta-section h2 {
  font-size: 2.5rem;
  margin: 0 0 20px;
  font-weight: 700;
}

.cta-section p {
  font-size: 1.3rem;
  margin-bottom: 40px;
  opacity: 0.9;
}

.cta-button {
  background: white;
  color: #FF0000;
  border: none;
  padding: 18px 40px;
  font-size: 1.2rem;
  font-weight: 700;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  display: inline-flex;
  align-items: center;
  gap: 10px;
}

.cta-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
  background: #f8f9fa;
}

.button-arrow {
  transition: transform 0.3s ease;
}

.cta-button:hover .button-arrow {
  transform: translateX(5px);
}

.cta-decoration {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.decoration-circle {
  position: absolute;
  width: 200px;
  height: 200px;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  top: -100px;
  right: -100px;
}

.decoration-line {
  position: absolute;
  width: 300px;
  height: 2px;
  background: rgba(255, 255, 255, 0.2);
  bottom: 20px;
  left: -150px;
  transform: rotate(-15deg);
}

/* Responsive Design */
@media (max-width: 960px) {
  .our-story {
    flex-direction: column;
    gap: 40px;
  }

  .story-stats {
    justify-content: center;
  }

  .about-hero h1 {
    font-size: 3rem;
  }

  .story-content h2,
  .mission-header h2,
  .achievements-header h2 {
    font-size: 2.3rem;
  }
}

@media (max-width: 600px) {
  .about-hero {
    padding: 80px 0 60px;
  }

  .about-hero h1 {
    font-size: 2.5rem;
  }

  .story-stats {
    flex-direction: column;
    gap: 20px;
  }

  .mission-grid {
    grid-template-columns: 1fr;
    gap: 30px;
  }

  .achievement-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .cta-section {
    padding: 60px 20px;
  }

  .cta-section h2 {
    font-size: 2rem;
  }
}

@media (max-width: 400px) {
  .achievement-grid {
    grid-template-columns: 1fr;
  }
}


</style>
@endsection
