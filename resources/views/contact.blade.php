@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="ct-wrap">

  {{-- Hero --}}
  <section class="ct-hero">
    <div class="ct-hero__deco"></div>
    <div class="ct-hero__inner">
      <span class="ct-tag">We'd love to hear from you</span>
      <h1 class="ct-hero__title">Get in <em>touch.</em></h1>
      <p class="ct-hero__sub">We're here to help with all your luxury car rental needs — reach out any time.</p>
    </div>
  </section>

  {{-- Main Content --}}
  <div class="ct-body">

    {{-- Info Cards --}}
    <aside class="ct-info">
      <div class="ct-info-card">
        <div class="ct-info-card__icon">📞</div>
        <div>
          <h3 class="ct-info-card__title">Call Us</h3>
          <p class="ct-info-card__val">+254-717-475-336</p>
          <p class="ct-info-card__sub">Mon–Fri: 9AM – 6PM</p>
        </div>
      </div>
      <div class="ct-info-card">
        <div class="ct-info-card__icon">✉️</div>
        <div>
          <h3 class="ct-info-card__title">Email Us</h3>
          <p class="ct-info-card__val">rentgo@gmail.com</p>
          <p class="ct-info-card__sub">We reply within 24 hours</p>
        </div>
      </div>
      <div class="ct-info-card">
        <div class="ct-info-card__icon">📍</div>
        <div>
          <h3 class="ct-info-card__title">Visit Us</h3>
          <p class="ct-info-card__val">Kenya Railways Station</p>
          <p class="ct-info-card__sub">Nairobi, Kenya</p>
        </div>
      </div>
    </aside>

    {{-- Form --}}
    <div class="ct-form-wrap">
      @if(session('success'))
        <div class="ct-success">
          <div class="ct-success__icon">✓</div>
          <h2 class="ct-success__title">Message sent!</h2>
          <p class="ct-success__body">{{ session('success') }}</p>
          <a href="{{ route('contact') }}" class="ct-btn ct-btn--outline">Send another message</a>
        </div>
      @else
        <form class="ct-form" method="POST" action="{{ route('contact.submit') }}">
          @csrf
          <h2 class="ct-form__title">Send us a message</h2>
          <p class="ct-form__sub">Fill in the form and we'll get back to you shortly.</p>

          <div class="ct-field">
            <label class="ct-label" for="name">Full Name <span class="ct-req">*</span></label>
            <input class="ct-input @error('name') ct-input--err @enderror" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your full name">
            @error('name')<p class="ct-err">{{ $message }}</p>@enderror
          </div>

          <div class="ct-row">
            <div class="ct-field">
              <label class="ct-label" for="email">Email Address <span class="ct-req">*</span></label>
              <input class="ct-input @error('email') ct-input--err @enderror" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="your@email.com">
              @error('email')<p class="ct-err">{{ $message }}</p>@enderror
            </div>
            <div class="ct-field">
              <label class="ct-label" for="phone">Phone <span class="ct-opt">(optional)</span></label>
              <input class="ct-input @error('phone') ct-input--err @enderror" type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+254 XXX XXX XXX">
              @error('phone')<p class="ct-err">{{ $message }}</p>@enderror
            </div>
          </div>

          <div class="ct-field">
            <label class="ct-label" for="subject">Subject</label>
            <select class="ct-input ct-select" name="subject" id="subject">
              <option value="General Inquiry"   {{ old('subject')=='General Inquiry'   ? 'selected' : '' }}>General Inquiry</option>
              <option value="Car Rental"        {{ old('subject')=='Car Rental'        ? 'selected' : '' }}>Car Rental</option>
              <option value="Luxury Fleet"      {{ old('subject')=='Luxury Fleet'      ? 'selected' : '' }}>Luxury Fleet</option>
              <option value="Corporate Rentals" {{ old('subject')=='Corporate Rentals' ? 'selected' : '' }}>Corporate Rentals</option>
              <option value="Technical Support" {{ old('subject')=='Technical Support' ? 'selected' : '' }}>Technical Support</option>
              <option value="Feedback"          {{ old('subject')=='Feedback'          ? 'selected' : '' }}>Feedback</option>
            </select>
          </div>

          <div class="ct-field">
            <label class="ct-label" for="message">Message <span class="ct-req">*</span></label>
            <textarea class="ct-input ct-textarea @error('message') ct-input--err @enderror" name="message" id="message" rows="5" placeholder="Tell us how we can help you…">{{ old('message') }}</textarea>
            @error('message')<p class="ct-err">{{ $message }}</p>@enderror
          </div>

          <button type="submit" class="ct-btn ct-btn--primary">Send Message →</button>
        </form>
      @endif
    </div>

  </div>

  {{-- FAQ Strip --}}
  <section class="ct-faq">
    <div class="ct-faq__head">
      <span class="ct-tag ct-tag--coral">Quick Answers</span>
      <h2 class="ct-section-title">Common <em>questions.</em></h2>
    </div>
    <div class="ct-faq__grid">
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">How do I book a luxury car?</h3>
        <p class="ct-faq-card__a">Browse our premium fleet, select your vehicle, choose your rental dates, and complete the booking online. Simple and fast.</p>
      </div>
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">What documents do I need?</h3>
        <p class="ct-faq-card__a">A valid driver's licence, passport or national ID, and a credit card for the security deposit. International visitors may also need an IDP.</p>
      </div>
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">Do you offer delivery?</h3>
        <p class="ct-faq-card__a">Yes — complimentary delivery and pickup within Nairobi CBD. Extended delivery areas are available for an additional fee.</p>
      </div>
    </div>
  </section>

</div>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --cream:   #fdf8f3;
  --peach:   #f5ede3;
  --peach-2: #eeddd0;
  --coral:   #d4501a;
  --coral-2: #e8692e;
  --warm-dk: #3d2b1f;
  --warm-md: #7a5c4a;
  --warm-lt: #b89b8a;
  --white:   #ffffff;
  --radius:  16px;
  --font-d:  'Fraunces', Georgia, serif;
  --font-b:  'Plus Jakarta Sans', system-ui, sans-serif;
  --max:     1100px;
  --pad:     clamp(24px, 6vw, 80px);
  --section: clamp(60px, 8vw, 100px);
}

body { background: var(--cream); }
.ct-wrap { font-family: var(--font-b); color: var(--warm-dk); background: var(--cream); overflow-x: hidden; }

/* ── Shared ── */
.ct-tag {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 0.72rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
  color: var(--warm-md); background: var(--peach-2);
  padding: 7px 16px; border-radius: 50px; margin-bottom: 20px;
}
.ct-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--coral); display:inline-block; }
.ct-tag--coral  { color: var(--coral); background: rgba(212,80,26,0.1); }

.ct-section-title {
  font-family: var(--font-d); font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 400; line-height: 1.2; color: var(--warm-dk); margin-bottom: 16px;
}
.ct-section-title em { font-style: italic; color: var(--coral); }

/* ── Hero ── */
.ct-hero {
  position: relative; background: var(--peach);
  padding: clamp(70px, 10vw, 120px) var(--pad) clamp(60px, 8vw, 100px);
  overflow: hidden;
}
.ct-hero__deco {
  position: absolute; width: 480px; height: 480px; border-radius: 50%;
  border: 1.5px solid var(--peach-2); top: -160px; right: -120px; pointer-events: none;
}
.ct-hero__deco::after {
  content:''; position:absolute; width:280px; height:280px; border-radius:50%;
  border: 1.5px solid var(--peach-2); top:110px; left:60px;
}
.ct-hero__inner { position:relative; z-index:1; max-width: var(--max); margin: 0 auto; }
.ct-hero__title {
  font-family: var(--font-d); font-size: clamp(2.8rem, 7vw, 5rem);
  font-weight: 400; line-height: 1.1; color: var(--warm-dk); margin-bottom: 18px;
}
.ct-hero__title em { font-style: italic; color: var(--coral); }
.ct-hero__sub {
  font-size: clamp(1rem, 2vw, 1.1rem); color: var(--warm-md);
  line-height: 1.75; max-width: 480px; font-weight: 300;
}

/* ── Body layout ── */
.ct-body {
  display: grid; grid-template-columns: 300px 1fr;
  gap: clamp(32px, 5vw, 64px);
  max-width: var(--max); margin: 0 auto;
  padding: var(--section) var(--pad); align-items: start;
}

/* ── Info cards ── */
.ct-info { display: flex; flex-direction: column; gap: 14px; }
.ct-info-card {
  background: var(--white); border: 1px solid var(--peach-2);
  border-radius: var(--radius); padding: 24px 22px;
  display: flex; align-items: flex-start; gap: 16px;
  transition: box-shadow 0.2s, transform 0.2s;
}
.ct-info-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.07); transform: translateY(-3px); }
.ct-info-card__icon { font-size: 1.6rem; flex-shrink: 0; margin-top: 2px; }
.ct-info-card__title { font-family: var(--font-d); font-size: 1.15rem; font-weight: 400; color: var(--warm-dk); margin-bottom: 4px; }
.ct-info-card__val   { font-size: 0.95rem; color: var(--warm-dk); font-weight: 500; margin-bottom: 2px; }
.ct-info-card__sub   { font-size: 0.8rem; color: var(--warm-lt); letter-spacing: 0.04em; }

/* ── Form card ── */
.ct-form-wrap {
  background: var(--white); border: 1px solid var(--peach-2);
  border-radius: 20px; padding: clamp(32px, 5vw, 52px);
}
.ct-form__title { font-family: var(--font-d); font-size: 1.9rem; font-weight: 400; color: var(--warm-dk); margin-bottom: 6px; }
.ct-form__sub   { font-size: 0.92rem; color: var(--warm-md); font-weight: 300; margin-bottom: 32px; }

.ct-field { margin-bottom: 22px; }
.ct-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 22px; }
.ct-row .ct-field { margin-bottom: 0; }

.ct-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--warm-dk); margin-bottom: 8px; }
.ct-req   { color: var(--coral); }
.ct-opt   { color: var(--warm-lt); font-weight: 400; }

.ct-input {
  width: 100%; padding: 13px 16px;
  border: 1.5px solid var(--peach-2); border-radius: 12px;
  font-size: 0.95rem; font-family: var(--font-b);
  background: var(--cream); color: var(--warm-dk);
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  appearance: none;
}
.ct-input:focus {
  outline: none; border-color: var(--coral);
  background: var(--white); box-shadow: 0 0 0 3px rgba(212,80,26,0.12);
}
.ct-input::placeholder { color: var(--warm-lt); }
.ct-input--err { border-color: var(--coral); background: rgba(212,80,26,0.04); }
.ct-select { cursor: pointer; }
.ct-textarea { resize: vertical; min-height: 130px; }
.ct-err { font-size: 0.82rem; color: var(--coral); margin-top: 6px; font-weight: 500; }

/* ── Buttons ── */
.ct-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  font-family: var(--font-b); font-size: 0.92rem; font-weight: 600;
  padding: 14px 30px; border-radius: 50px; cursor: pointer;
  text-decoration: none; border: none; transition: all 0.2s; width: 100%;
}
.ct-btn--primary {
  background: var(--coral); color: var(--white);
  box-shadow: 0 4px 16px rgba(212,80,26,0.25);
}
.ct-btn--primary:hover { background: var(--coral-2); box-shadow: 0 8px 24px rgba(212,80,26,0.3); transform: translateY(-2px); }
.ct-btn--outline {
  background: transparent; color: var(--coral);
  border: 1.5px solid var(--coral); margin-top: 16px; width: auto;
}
.ct-btn--outline:hover { background: rgba(212,80,26,0.06); }

/* ── Success ── */
.ct-success { text-align: center; padding: 48px 20px; }
.ct-success__icon {
  width: 72px; height: 72px; border-radius: 50%;
  background: var(--coral); color: var(--white);
  font-size: 2rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 24px; box-shadow: 0 8px 24px rgba(212,80,26,0.3);
}
.ct-success__title { font-family: var(--font-d); font-size: 2rem; color: var(--warm-dk); margin-bottom: 10px; }
.ct-success__body  { font-size: 1rem; color: var(--warm-md); font-weight: 300; }

/* ── FAQ strip ── */
.ct-faq {
  background: var(--peach); border-top: 1px solid var(--peach-2);
  padding: var(--section) var(--pad);
}
.ct-faq__head { max-width: var(--max); margin: 0 auto 48px; }
.ct-faq__grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; max-width: var(--max); margin: 0 auto; }

.ct-faq-card {
  background: var(--white); border: 1px solid var(--peach-2);
  border-radius: var(--radius); padding: 36px 28px;
  transition: box-shadow 0.2s, transform 0.2s;
}
.ct-faq-card:hover { box-shadow: 0 10px 28px rgba(0,0,0,0.07); transform: translateY(-4px); }
.ct-faq-card__q { font-family: var(--font-d); font-size: 1.2rem; font-weight: 400; color: var(--warm-dk); margin-bottom: 12px; }
.ct-faq-card__a { font-size: 0.93rem; line-height: 1.8; color: var(--warm-md); font-weight: 300; }

/* ── Responsive ── */
@media (max-width: 860px) {
  .ct-body { grid-template-columns: 1fr; }
  .ct-faq__grid { grid-template-columns: 1fr; }
}
@media (max-width: 540px) {
  .ct-row { grid-template-columns: 1fr; }
}
</style>

@endsection
