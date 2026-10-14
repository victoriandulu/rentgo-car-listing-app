@extends('layouts.app')

@section('title', 'About Us | WeSellGaris | Quality Used Cars & Imports in Kenya')
@section('meta_description', 'Learn about WeSellGaris: quality local cars and imports from Japan, South Africa and Dubai, with transparent pricing and support before, during and after your purchase.')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<div class="ab-wrap">

  {{-- Hero --}}
  <section class="ab-hero">
    <div class="ab-hero__deco" aria-hidden="true"></div>
    <div class="ab-hero__inner">
      <span class="ab-tag">About WeSellGaris</span>
      <h1 class="ab-hero__title">Quality cars. Fair prices.<br><em>Delivered to you.</em></h1>
      <p class="ab-hero__sub">WeSellGaris helps you buy, import and sell quality cars in Kenya, with honest pricing and real support at every step.</p>
      <div class="ab-hero__pills">
        <div class="ab-pill">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          5,000+ Happy Clients
        </div>
        <div class="ab-pill">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          4.9 Avg Rating
        </div>
        <div class="ab-pill">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          24 / 7 Support
        </div>
      </div>
    </div>
  </section>

  {{-- Story --}}
  <section class="ab-story">
    <div class="ab-story__visual">
      <div class="ab-story__card">
        <div class="ab-story__icon" aria-hidden="true">
          <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg>
        </div>
        <p class="ab-story__card-title">Wide Selection</p>
        <p class="ab-story__card-sub">100+ quality vehicles</p>
      </div>
      <div class="ab-story__stat-stack">
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">2018</span>
          <span class="ab-mini-stat__lbl">Founded</span>
        </div>
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">100+</span>
          <span class="ab-mini-stat__lbl">Vehicles</span>
        </div>
        <div class="ab-mini-stat">
          <span class="ab-mini-stat__num">5K+</span>
          <span class="ab-mini-stat__lbl">Happy Clients</span>
        </div>
      </div>
    </div>
    <div class="ab-story__text">
      <span class="ab-tag">Our Journey</span>
      <h2 class="ab-section-title">The WeSellGaris <em>story.</em></h2>
      <p class="ab-body">Founded in 2018 with a small but handpicked collection of quality vehicles, WeSellGaris set out to change what buying a car in Kenya could feel like: transparent, personal, and worthy of the cars themselves.</p>
      <p class="ab-body">Today we offer local cars and imports sourced from Japan, South Africa and Dubai. The principle stays the same: every journey deserves a vehicle you can trust, and a team that stands behind it.</p>
      <a href="{{ url('/vehicles') }}" class="ab-btn">Browse Vehicles <span>→</span></a>
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
        <div class="ab-val-card__icon" aria-hidden="true">★</div>
        <h3 class="ab-val-card__title">Excellence</h3>
        <p class="ab-val-card__body">Quality vehicles, personalized service, and seamless processes, consistently exceeding every expectation.</p>
      </div>
      <div class="ab-val-card ab-val-card--feature">
        <div class="ab-val-card__icon" aria-hidden="true">✦</div>
        <h3 class="ab-val-card__title">Integrity</h3>
        <p class="ab-val-card__body">Transparent pricing, honest communication, and genuine care for every client from first inquiry to final handover.</p>
      </div>
      <div class="ab-val-card">
        <div class="ab-val-card__icon" aria-hidden="true">◆</div>
        <h3 class="ab-val-card__title">Quality</h3>
        <p class="ab-val-card__body">Every vehicle carefully checked and presented properly, backed by ongoing support for total peace of mind.</p>
      </div>
    </div>
  </section>

  {{-- Numbers --}}
  <section class="ab-numbers">
    <div class="ab-numbers__inner">
      <div class="ab-numbers__head">
        <span class="ab-tag ab-tag--light">Our Impact</span>
        <h2 class="ab-section-title">Numbers that <em>matter.</em></h2>
      </div>
      <div class="ab-numbers__grid">
        <div class="ab-num">
          <span class="ab-num__val">5,000+</span>
          <span class="ab-num__lbl">Happy Customers</span>
        </div>
        <div class="ab-num">
          <span class="ab-num__val">100+</span>
          <span class="ab-num__lbl">Vehicles</span>
        </div>
        <div class="ab-num">
          <span class="ab-num__val">4.9</span>
          <span class="ab-num__lbl">Customer Rating</span>
        </div>
        <div class="ab-num">
          <span class="ab-num__val">24/7</span>
          <span class="ab-num__lbl">Customer Support</span>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="ab-cta">
    <div class="ab-cta__inner">
      <h2 class="ab-cta__title">Ready to find <em>your next car?</em></h2>
      <p class="ab-cta__sub">Browse our vehicles, or list your own car and reach buyers across Kenya.</p>
      <div class="ab-cta__btns">
        <a href="{{ url('/vehicles') }}" class="ab-btn">Browse Vehicles <span>→</span></a>
        @auth
          <a href="{{ route('cars.create') }}" class="ab-btn ab-btn--outline">Sell Your Car</a>
        @else
          <a href="{{ url('/sell') }}" class="ab-btn ab-btn--outline">Sell Your Car</a>
        @endauth
      </div>
    </div>
  </section>

</div>

<style>
:root {
  --cream:#F5EBDD; --espresso:#3A2920; --orange:#D94F16; --yellow:#F5C400;
  --terracotta:#B94314; --beige:#EAD9C6; --peach:#F3D7C8;
  --font-d:'Playfair Display',Georgia,serif; --font-b:'Inter',system-ui,sans-serif;
  --pad:clamp(20px,5vw,80px);
}
.ab-wrap, .ab-wrap *, .ab-wrap *::before, .ab-wrap *::after { box-sizing: border-box; }
.ab-wrap { font-family: var(--font-b); color: var(--espresso); background: var(--cream); width:100%; overflow-x:hidden; }
:where(.ab-wrap h1, .ab-wrap h2, .ab-wrap h3, .ab-wrap p) { margin: 0; }

/* Shared */
.ab-tag {
  display:inline-flex; align-items:center; gap:8px; margin-bottom:26px;
  font-size:.66rem; font-weight:600; letter-spacing:.14em; text-transform:uppercase;
  background:var(--peach); padding:8px 15px; border-radius:50px;
}
.ab-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--orange); }
.ab-tag--light { background:rgba(245,235,221,.12); color:var(--cream); }
.ab-tag--light::before { background:var(--yellow); }

.ab-section-title { font-family:var(--font-d); font-size:clamp(1.9rem,3.6vw,2.8rem); font-weight:600; line-height:1.15; margin-bottom:20px; }
.ab-section-title em { font-style:italic; color:var(--orange); }
.ab-body { font-size:1rem; line-height:1.85; opacity:.8; margin-bottom:16px; }

.ab-btn {
  display:inline-flex; align-items:center; justify-content:center; gap:10px; min-height:48px;
  padding:14px 30px; border-radius:50px; background:var(--orange); color:#fff; border:1.5px solid var(--orange);
  font:600 .9rem var(--font-b); text-decoration:none; box-shadow:0 6px 20px rgba(217,79,22,.3); transition:.2s; margin-top:10px;
}
.ab-btn:hover { background:var(--terracotta); border-color:var(--terracotta); color:#fff; transform:translateY(-2px); gap:14px; }
.ab-btn--outline { background:transparent; color:var(--orange); box-shadow:none; }
.ab-btn--outline:hover { background:var(--peach); color:var(--terracotta); border-color:var(--orange); }
.ab-btn:focus-visible { outline:3px solid var(--yellow); outline-offset:2px; }

/* Hero */
.ab-hero { position:relative; background:var(--cream); padding:clamp(56px,9vw,110px) var(--pad) clamp(48px,7vw,88px); overflow:hidden; border-bottom:1px solid var(--beige); }
.ab-hero__deco { position:absolute; width:500px; height:500px; border-radius:50%; border:1.5px solid var(--beige); top:-180px; right:-120px; pointer-events:none; }
.ab-hero__deco::after { content:''; position:absolute; width:290px; height:290px; border-radius:50%; border:1.5px solid var(--beige); top:120px; left:60px; }
.ab-hero__inner { position:relative; z-index:1; max-width:1100px; margin:0 auto; }
.ab-hero__title { font-family:var(--font-d); font-size:clamp(2.4rem,5.6vw,4.4rem); font-weight:600; line-height:1.1; margin-bottom:20px; }
.ab-hero__title em { font-style:italic; color:var(--orange); }
.ab-hero__sub { font-size:clamp(.95rem,1.5vw,1.12rem); opacity:.78; max-width:540px; line-height:1.7; margin-bottom:34px; }
.ab-hero__pills { display:flex; flex-wrap:wrap; gap:10px; }
.ab-pill { display:inline-flex; align-items:center; gap:8px; background:#fff; border:1px solid var(--beige); padding:10px 18px; border-radius:50px; font-size:.84rem; font-weight:600; box-shadow:0 2px 8px rgba(58,41,32,.06); }
.ab-pill svg { color:var(--orange); }

/* Story */
.ab-story { display:grid; grid-template-columns:1fr 1.3fr; gap:clamp(36px,6vw,76px); align-items:center; max-width:1100px; margin:0 auto; padding:clamp(52px,7vw,100px) var(--pad); }
.ab-story__visual { display:flex; flex-direction:column; gap:14px; }
.ab-story__card { background:var(--espresso); color:var(--cream); border-radius:18px; padding:40px 34px; }
.ab-story__icon { width:62px; height:62px; border-radius:16px; background:rgba(245,196,0,.14); color:var(--yellow); display:flex; align-items:center; justify-content:center; margin-bottom:20px; }
.ab-story__card-title { font-family:var(--font-d); font-size:1.55rem; font-weight:600; margin-bottom:6px; }
.ab-story__card-sub { font-size:.76rem; letter-spacing:.12em; text-transform:uppercase; opacity:.65; }
.ab-story__stat-stack { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
.ab-mini-stat { background:#fff; border:1px solid var(--beige); border-radius:14px; padding:20px 10px; text-align:center; box-shadow:0 2px 8px rgba(58,41,32,.06); }
.ab-mini-stat__num { display:block; font-family:var(--font-d); font-size:1.6rem; font-weight:600; color:var(--orange); line-height:1; margin-bottom:7px; }
.ab-mini-stat__lbl { font-size:.66rem; letter-spacing:.1em; text-transform:uppercase; opacity:.65; }

/* Values */
.ab-values { background:var(--peach); padding:clamp(52px,7vw,100px) var(--pad); }
.ab-values__head { max-width:1100px; margin:0 auto 40px; }
.ab-values__head .ab-section-title { margin-bottom:0; }
.ab-values__head .ab-tag { background:#fff; }
.ab-values__grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; max-width:1100px; margin:0 auto; }
.ab-val-card { background:#fff; border:1px solid var(--beige); border-radius:18px; padding:40px 30px; box-shadow:0 2px 8px rgba(58,41,32,.06); transition:box-shadow .2s, transform .2s; }
.ab-val-card:hover { box-shadow:0 12px 30px rgba(58,41,32,.12); transform:translateY(-4px); }
.ab-val-card--feature { background:var(--orange); border-color:var(--orange); color:#fff; }
.ab-val-card__icon { font-size:1.3rem; color:var(--orange); display:block; margin-bottom:18px; }
.ab-val-card--feature .ab-val-card__icon { color:var(--yellow); }
.ab-val-card__title { font-family:var(--font-d); font-size:1.5rem; font-weight:600; margin-bottom:12px; }
.ab-val-card__body { font-size:.94rem; line-height:1.75; opacity:.8; }
.ab-val-card--feature .ab-val-card__body { opacity:.92; }

/* Numbers */
.ab-numbers { background:var(--espresso); color:var(--cream); padding:clamp(52px,7vw,96px) var(--pad); }
.ab-numbers__inner { max-width:1100px; margin:0 auto; }
.ab-numbers__head { margin-bottom:40px; }
.ab-numbers__head .ab-section-title { margin-bottom:0; }
.ab-numbers .ab-section-title em { color:var(--yellow); }
.ab-numbers__grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.ab-num { background:rgba(245,235,221,.06); border:1px solid rgba(245,235,221,.14); border-radius:18px; padding:34px 20px; text-align:center; transition:background .2s, transform .2s; }
.ab-num:hover { background:rgba(245,235,221,.1); transform:translateY(-4px); }
.ab-num__val { display:block; font-family:var(--font-d); font-size:clamp(1.9rem,3.2vw,2.8rem); font-weight:600; color:var(--yellow); line-height:1; margin-bottom:12px; }
.ab-num__lbl { font-size:.74rem; letter-spacing:.1em; text-transform:uppercase; opacity:.75; }

/* CTA */
.ab-cta { background:var(--cream); padding:clamp(52px,7vw,96px) var(--pad); }
.ab-cta__inner { max-width:1100px; margin:0 auto; }
.ab-cta__title { font-family:var(--font-d); font-size:clamp(2rem,4vw,3rem); font-weight:600; line-height:1.15; margin-bottom:14px; max-width:600px; }
.ab-cta__title em { font-style:italic; color:var(--orange); }
.ab-cta__sub { font-size:1rem; opacity:.78; line-height:1.7; margin-bottom:26px; max-width:520px; }
.ab-cta__btns { display:flex; flex-wrap:wrap; gap:12px; }
.ab-cta__btns .ab-btn { margin-top:0; }

/* Responsive */
@media (max-width:840px) {
  .ab-story { grid-template-columns:1fr; }
  .ab-values__grid { grid-template-columns:1fr; }
  .ab-numbers__grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:500px) {
  .ab-hero__pills { flex-direction:column; align-items:flex-start; }
  .ab-mini-stat { padding:16px 6px; }
  .ab-cta__btns .ab-btn { width:100%; }
}
@media (prefers-reduced-motion:reduce) { .ab-wrap * { transition:none !important; } }
</style>

@endsection
