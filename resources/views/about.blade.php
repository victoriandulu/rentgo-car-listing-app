@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="ab-wrap">

  {{-- Hero --}}
  <section class="ab-hero">
    <div class="ab-hero__deco"></div>
    <div class="ab-hero__inner">
      {{-- <span class="ab-tag">Est. 2018 · Premium Car Rentals</span> --}}
      <h1 class="ab-hero__title">Luxury car rentals,<br><em>redefined.</em></h1>
      <p class="ab-hero__sub">WeSellGaris places the world's finest automobiles at your fingertips — for the moments that deserve nothing less.</p>
      <div class="ab-hero__pills">
        <div class="ab-pill">🎯 5,000+ Happy Clients</div>
        <div class="ab-pill">⭐ 4.9 Avg Rating</div>
        <div class="ab-pill">🕒 24 / 7 Support</div>
      </div>
    </div>
  </section>

  {{-- Story --}}
  <section class="ab-story">
    <div class="ab-story__visual">
      <div class="ab-story__card">
        <div class="ab-story__emoji">🚗</div>
        <p class="ab-story__card-title">Premium Fleet</p>
        <p class="ab-story__card-sub">100+ luxury vehicles</p>
      </div>
      <div class="ab-story__stat-stack">
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">2018</span>
          <span class="ab-mini-stat__lbl">Founded</span>
        </div>
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">100+</span>
          <span class="ab-mini-stat__lbl">Luxury Cars</span>
        </div>
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">5K+</span>
          <span class="ab-mini-stat__lbl">Happy Clients</span>
        </div>
      </div>
    </div>
    <div class="ab-story__text">
      <span class="ab-tag">Our Journey</span>
      <h2 class="ab-section-title">The WesellGaris <em>story.</em></h2>
      <p class="ab-body">Founded in 2018 with a small but handpicked collection of premium vehicles, WeSellGaris set out to change what luxury car rental could feel like — seamless, personal, and worthy of the cars themselves.</p>
      <p class="ab-body">Today we are one of the region's most trusted rental services. The principle stays the same: every journey deserves a vehicle as exceptional as the destination.</p>
    </div>
  </section>

  {{-- Values --}}
  <section class="ab-values">
    <div class="ab-values__head">
      <span class="ab-tag">What Drives Us</span>
      <h2 class="ab-section-title">Our core <em>values.</em></h2>
    </div>
    <div class="ab-values__grid">
      <div class="ab-val-card">
        <div class="ab-val-card__icon">★</div>
        <h3 class="ab-val-card__title">Excellence</h3>
        <p class="ab-val-card__body">Premium vehicles, personalized service, and seamless processes — consistently exceeding every expectation.</p>
      </div>
      <div class="ab-val-card ab-val-card--feature">
        <div class="ab-val-card__icon">✦</div>
        <h3 class="ab-val-card__title">Integrity</h3>
        <p class="ab-val-card__body">Transparent pricing, honest communication, and genuine care for every client from first inquiry to final handover.</p>
      </div>
      <div class="ab-val-card">
        <div class="ab-val-card__icon">◆</div>
        <h3 class="ab-val-card__title">Quality</h3>
        <p class="ab-val-card__body">Every vehicle meticulously maintained, immaculately presented, backed by 24/7 assistance for total peace of mind.</p>
      </div>
    </div>
  </section>

  {{-- Numbers --}}
  <section class="ab-numbers">
    <div class="ab-numbers__head">
      <span class="ab-tag ab-tag--coral">Our Impact</span>
      <h2 class="ab-section-title">Numbers that <em>matter.</em></h2>
    </div>
    <div class="ab-numbers__grid">
      <div class="ab-num">
        <span class="ab-num__icon">🎯</span>
        <span class="ab-num__val">5,000+</span>
        <span class="ab-num__lbl">Happy Customers</span>
      </div>
      <div class="ab-num">
        <span class="ab-num__icon">🚘</span>
        <span class="ab-num__val">100+</span>
        <span class="ab-num__lbl">Luxury Vehicles</span>
      </div>
      <div class="ab-num">
        <span class="ab-num__icon">⭐</span>
        <span class="ab-num__val">4.9</span>
        <span class="ab-num__lbl">Customer Rating</span>
      </div>
      <div class="ab-num">
        <span class="ab-num__icon">🕒</span>
        <span class="ab-num__val">24/7</span>
        <span class="ab-num__lbl">Customer Support</span>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="ab-cta">
    <div class="ab-cta__inner">
      <h2 class="ab-cta__title">Ready to experience <em>WeSellGaris?</em></h2>
      <p class="ab-cta__sub">Discover our premium fleet and book your dream car today.</p>
      <a href="#" class="ab-cta-btn">Browse Our Fleet <span>→</span></a>
    </div>
  </section>

</div>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --cream:    #fdf8f3;
  --peach:    #f5ede3;
  --peach-2:  #eeddd0;
  --coral:    #d4501a;
  --coral-2:  #e8692e;
  --warm-dk:  #3d2b1f;
  --warm-md:  #7a5c4a;
  --warm-lt:  #b89b8a;
  --white:    #ffffff;
  --radius:   18px;
  --font-d:   'Fraunces', Georgia, serif;
  --font-b:   'Plus Jakarta Sans', system-ui, sans-serif;
  --max:      1100px;
  --pad:      clamp(24px, 6vw, 80px);
  --section:  clamp(64px, 9vw, 110px);
}

body { background: var(--cream); }

.ab-wrap {
  font-family: var(--font-b);
  color: var(--warm-dk);
  background: var(--cream);
  overflow-x: hidden;
}

/* ── Shared ── */
.ab-tag {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 0.72rem;
  font-weight: 600;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--warm-md);
  background: var(--peach-2);
  padding: 7px 16px;
  border-radius: 50px;
  margin-bottom: 20px;
}
.ab-tag--coral {
  color: var(--coral);
  background: rgba(212,80,26,0.1);
}
.ab-tag::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--coral);
  display: inline-block;
}

.ab-section-title {
  font-family: var(--font-d);
  font-size: clamp(2rem, 4.5vw, 3.2rem);
  font-weight: 400;
  line-height: 1.2;
  color: var(--warm-dk);
  margin-bottom: 20px;
}
.ab-section-title em {
  font-style: italic;
  color: var(--coral);
}

.ab-body {
  font-size: 1rem;
  line-height: 1.85;
  color: var(--warm-md);
  margin-bottom: 16px;
  font-weight: 300;
}

/* ── Hero ── */
.ab-hero {
  position: relative;
  background: var(--peach);
  padding: clamp(70px, 12vw, 130px) var(--pad) clamp(64px, 10vw, 110px);
  overflow: hidden;
}
.ab-hero__deco {
  position: absolute;
  width: 520px; height: 520px;
  border-radius: 50%;
  border: 1.5px solid var(--peach-2);
  top: -180px; right: -140px;
  pointer-events: none;
}
.ab-hero__deco::after {
  content: '';
  position: absolute;
  width: 320px; height: 320px;
  border-radius: 50%;
  border: 1.5px solid var(--peach-2);
  top: 120px; left: 60px;
}
.ab-hero__inner {
  position: relative;
  z-index: 1;
  max-width: var(--max);
  margin: 0 auto;
}
.ab-hero__title {
  font-family: var(--font-d);
  font-size: clamp(2.8rem, 7vw, 5.5rem);
  font-weight: 400;
  line-height: 1.1;
  color: var(--warm-dk);
  margin-bottom: 22px;
}
.ab-hero__title em {
  font-style: italic;
  color: var(--coral);
}
.ab-hero__sub {
  font-size: clamp(1rem, 2vw, 1.15rem);
  color: var(--warm-md);
  line-height: 1.75;
  max-width: 500px;
  font-weight: 300;
  margin-bottom: 40px;
}
.ab-hero__pills {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}
.ab-pill {
  background: var(--white);
  border: 1px solid var(--peach-2);
  color: var(--warm-dk);
  padding: 10px 20px;
  border-radius: 50px;
  font-size: 0.88rem;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* ── Story ── */
.ab-story {
  display: grid;
  grid-template-columns: 1fr 1.3fr;
  gap: clamp(40px, 6vw, 80px);
  align-items: center;
  max-width: var(--max);
  margin: 0 auto;
  padding: var(--section) var(--pad);
}
.ab-story__visual {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.ab-story__card {
  background: var(--peach);
  border-radius: var(--radius);
  padding: 44px 36px;
  border: 1px solid var(--peach-2);
}
.ab-story__emoji { font-size: 2.6rem; margin-bottom: 16px; }
.ab-story__card-title {
  font-family: var(--font-d);
  font-size: 1.5rem;
  font-weight: 400;
  color: var(--warm-dk);
  margin-bottom: 4px;
}
.ab-story__card-sub {
  font-size: 0.82rem;
  color: var(--warm-lt);
  letter-spacing: 0.1em;
  text-transform: uppercase;
}
.ab-story__stat-stack {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}
.ab-mini-stat {
  background: var(--white);
  border: 1px solid var(--peach-2);
  border-radius: 14px;
  padding: 22px 16px;
  text-align: center;
}
.ab-mini-stat__num {
  display: block;
  font-family: var(--font-d);
  font-size: 1.7rem;
  font-weight: 400;
  color: var(--coral);
  line-height: 1;
  margin-bottom: 6px;
}
.ab-mini-stat__lbl {
  font-size: 0.72rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--warm-lt);
}

/* ── Values ── */
.ab-values {
  background: var(--peach);
  padding: var(--section) var(--pad);
}
.ab-values__head {
  max-width: var(--max);
  margin: 0 auto 48px;
}
.ab-values__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  max-width: var(--max);
  margin: 0 auto;
}
.ab-val-card {
  background: var(--white);
  border-radius: var(--radius);
  padding: 44px 32px;
  border: 1px solid var(--peach-2);
  transition: box-shadow 0.2s, transform 0.2s;
}
.ab-val-card:hover {
  box-shadow: 0 12px 32px rgba(0,0,0,0.07);
  transform: translateY(-4px);
}
.ab-val-card--feature {
  background: var(--coral);
  border-color: var(--coral);
}
.ab-val-card--feature .ab-val-card__icon,
.ab-val-card--feature .ab-val-card__title,
.ab-val-card--feature .ab-val-card__body { color: var(--white); }
.ab-val-card--feature .ab-val-card__body { opacity: 0.85; }

.ab-val-card__icon {
  font-size: 1.3rem;
  color: var(--coral);
  display: block;
  margin-bottom: 20px;
}
.ab-val-card__title {
  font-family: var(--font-d);
  font-size: 1.55rem;
  font-weight: 400;
  color: var(--warm-dk);
  margin-bottom: 14px;
}
.ab-val-card__body {
  font-size: 0.96rem;
  line-height: 1.75;
  color: var(--warm-md);
  font-weight: 300;
}

/* ── Numbers ── */
.ab-numbers {
  padding: var(--section) var(--pad);
  max-width: var(--max);
  margin: 0 auto;
}
.ab-numbers__head { margin-bottom: 48px; }
.ab-numbers__grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
.ab-num {
  background: var(--white);
  border: 1px solid var(--peach-2);
  border-radius: var(--radius);
  padding: 36px 24px;
  text-align: center;
  transition: box-shadow 0.2s, transform 0.2s;
}
.ab-num:hover {
  box-shadow: 0 10px 28px rgba(0,0,0,0.06);
  transform: translateY(-4px);
}
.ab-num__icon { font-size: 1.8rem; display: block; margin-bottom: 14px; }
.ab-num__val {
  display: block;
  font-family: var(--font-d);
  font-size: clamp(1.8rem, 3vw, 2.6rem);
  font-weight: 400;
  color: var(--coral);
  line-height: 1;
  margin-bottom: 10px;
}
.ab-num__lbl {
  font-size: 0.78rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--warm-lt);
}

/* ── CTA ── */
.ab-cta {
  background: var(--peach);
  padding: var(--section) var(--pad);
  border-top: 1px solid var(--peach-2);
}
.ab-cta__inner {
  max-width: 600px;
}
.ab-cta__title {
  font-family: var(--font-d);
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 400;
  color: var(--warm-dk);
  line-height: 1.2;
  margin-bottom: 16px;
}
.ab-cta__title em {
  font-style: italic;
  color: var(--coral);
}
.ab-cta__sub {
  font-size: 1rem;
  color: var(--warm-md);
  line-height: 1.7;
  margin-bottom: 36px;
  font-weight: 300;
}
.ab-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--coral);
  color: var(--white);
  text-decoration: none;
  font-size: 0.92rem;
  font-weight: 600;
  padding: 16px 32px;
  border-radius: 50px;
  border: 1.5px solid var(--coral);
  transition: background 0.2s, gap 0.2s, box-shadow 0.2s;
  box-shadow: 0 4px 16px rgba(212,80,26,0.25);
}
.ab-cta-btn:hover {
  background: var(--coral-2);
  gap: 18px;
  box-shadow: 0 8px 24px rgba(212,80,26,0.3);
}

/* ── Responsive ── */
@media (max-width: 840px) {
  .ab-story { grid-template-columns: 1fr; }
  .ab-values__grid { grid-template-columns: 1fr; }
  .ab-numbers__grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
  .ab-hero__pills { flex-direction: column; }
  .ab-story__stat-stack { grid-template-columns: 1fr 1fr; }
  .ab-numbers__grid { grid-template-columns: 1fr 1fr; }
}
</style>

@endsection
