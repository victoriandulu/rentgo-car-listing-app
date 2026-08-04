@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,400;1,9..144,500;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="hm-wrap">

  {{-- ── Hero ── --}}
  <section class="hm-hero">

    {{-- Watermark --}}
    <div class="hm-watermark" aria-hidden="true">
      <span>We Sell</span>
      <span>Garis</span>
    </div>

    {{-- Vignette depth layer --}}
    <div class="hm-vignette" aria-hidden="true"></div>

    {{-- Left: Text --}}
    <div class="hm-hero__left">

      <h1 class="hm-hero__title">
        The smarter way<br>
        to <em>buy &amp; sell</em><br>
        your car.
      </h1>

      <p class="hm-hero__sub">
        Find a car that fits your personality, dream, and pocket — we'll handle the rest.
      </p>

      <div class="hm-hero__btns">
        <a href="{{ url('/vehicles') }}" class="hm-btn hm-btn--primary">
          Explore Vehicles
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        @auth
          <a href="{{ route('cars.create') }}" class="hm-btn hm-btn--outline">Sell Your Car</a>
        @endauth
        @guest
          <a href="{{ url('/sell') }}" class="hm-btn hm-btn--outline">Sell Your Car</a>
        @endguest
      </div>

      <div class="hm-stats">
        <div class="hm-stat">
          <span class="hm-stat__num">5,000+</span>
          <span class="hm-stat__lbl">Happy Clients</span>
        </div>
        <div class="hm-stat__div"></div>
        <div class="hm-stat">
          <span class="hm-stat__num">4.9</span>
          <span class="hm-stat__lbl">Avg Rating</span>
        </div>
        <div class="hm-stat__div"></div>
        <div class="hm-stat">
          <span class="hm-stat__num">100%</span>
          <span class="hm-stat__lbl">Verified &amp; Secure</span>
        </div>
      </div>

    </div>

    {{-- Right: Car Carousel (6 units) --}}
    <div class="hm-hero__right">
      <div class="hm-carousel" id="heroCarousel">
        <div class="hm-carousel__track" id="carouselTrack">
          {{-- 6 vehicle images – adjust filenames to match your assets --}}
          <div class="hm-carousel__slide"><img src="{{ asset('images/gwagon.png') }}" alt="Mercedes G-Wagon" /></div>
          <div class="hm-carousel__slide"><img src="{{ asset('images/Luxury_Sedan.png') }}" alt="Luxury Sedan" /></div>
          <div class="hm-carousel__slide"><img src="{{ asset('images/Sports_Coupe.png') }}" alt="Sports Coupe" /></div>
          <div class="hm-carousel__slide"><img src="{{ asset('images/Electric_SUV.png') }}" alt="Electric SUV" /></div>
          <div class="hm-carousel__slide"><img src="{{ asset('images/Offroad_Pickup.png') }}" alt="Offroad Pickup" /></div>
          <div class="hm-carousel__slide"><img src="{{ asset('images/Compact_Hatchback.png') }}" alt="Compact Hatchback" /></div>
        </div>
        {{-- Navigation dots --}}
        <div class="hm-carousel__dots" id="carouselDots"></div>
      </div>
    </div>

  </section>

  {{-- ── Search ── --}}
  <section class="hm-search">
    <div class="hm-container">
      <span class="hm-tag hm-tag--coral">Find Your Vehicle</span>
      <h2 class="hm-section-title">Search our <em>fleet.</em></h2>

      {{-- ACTION points directly to /vehicles so the query lands on that page --}}
      <form action="{{ url('/vehicles') }}" method="GET" class="hm-search__form" id="search-form">
        <input
          type="text"
          name="query"
          id="search-input"
          class="hm-search__input"
          placeholder="Search by make, model, or keyword…"
          autocomplete="off"
        />
        <button type="submit" class="hm-btn hm-btn--primary hm-search__btn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          Search
        </button>
      </form>
    </div>
  </section>

  {{-- ── Filters ── --}}
  <section class="hm-filters">
    <div class="hm-container">

      <div class="hm-filter-block">
        <span class="hm-tag">Filter by Price</span>
        <h2 class="hm-section-title">What's your <em>budget?</em></h2>
        <div class="hm-price-grid">
          <button class="hm-price-btn" onclick="filterByPrice(0,500000)">Under 500K</button>
          <button class="hm-price-btn" onclick="filterByPrice(500000,1000000)">500K – 1M</button>
          <button class="hm-price-btn" onclick="filterByPrice(1000000,2000000)">1M – 2M</button>
          <button class="hm-price-btn" onclick="filterByPrice(2000000,3000000)">2M – 3M</button>
          <button class="hm-price-btn" onclick="filterByPrice(3000000,5000000)">3M – 5M</button>
          <button class="hm-price-btn" onclick="filterByPrice(5000000,10000000)">5M – 10M</button>
          <button class="hm-price-btn hm-price-btn--accent" onclick="filterByPrice(10000000,999999999)">Above 10M</button>
        </div>
      </div>

      <div class="hm-select-row">
        <div class="hm-select-group">
          <label class="hm-select-label" for="brand-filter">Filter by Brand</label>
          <select id="brand-filter" class="hm-select" onchange="filterByBrand(this.value)">
            <option value="">All Brands</option>
            <option value="toyota">Toyota</option>
            <option value="honda">Honda</option>
            <option value="nissan">Nissan</option>
            <option value="mazda">Mazda</option>
            <option value="subaru">Subaru</option>
            <option value="mercedes">Mercedes-Benz</option>
            <option value="bmw">BMW</option>
            <option value="audi">Audi</option>
            <option value="volkswagen">Volkswagen</option>
            <option value="ford">Ford</option>
            <option value="landrover">Land Rover</option>
            <option value="mitsubishi">Mitsubishi</option>
          </select>
        </div>
        <div class="hm-select-group">
          <label class="hm-select-label" for="body-filter">Filter by Body Type</label>
          <select id="body-filter" class="hm-select" onchange="filterByBodyType(this.value)">
            <option value="">All Body Types</option>
            <option value="suv">SUV</option>
            <option value="sedan">Sedan</option>
            <option value="hatchback">Hatchback</option>
            <option value="pickup">Pickup</option>
            <option value="van">Van</option>
            <option value="coupe">Coupe</option>
            <option value="wagon">Wagon</option>
            <option value="convertible">Convertible</option>
          </select>
        </div>
      </div>

      <div class="hm-filter-cta">
        <a href="{{ url('/vehicles') }}" class="hm-btn hm-btn--primary">View All Vehicles →</a>
      </div>

    </div>
  </section>

</div>

<script>
function filterByPrice(min, max) {
  window.location.href = `{{ url('/vehicles') }}?price_min=${min}&price_max=${max}`;
}
function filterByBrand(brand) {
  if (brand) window.location.href = `{{ url('/vehicles') }}?make=${brand}`;
}
function filterByBodyType(type) {
  if (type) window.location.href = `{{ url('/vehicles') }}?body_type=${type}`;
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('search-form');
  const input = document.getElementById('search-input');

  form.addEventListener('submit', function (e) {
    const val = input.value.trim();
    if (!val) {
      e.preventDefault();
      window.location.href = '{{ url('/vehicles') }}';
      return;
    }
    // Otherwise, let the form submit normally
  });

  // --- Carousel logic ---
  const track = document.getElementById('carouselTrack');
  const dotsContainer = document.getElementById('carouselDots');
  const slides = track.querySelectorAll('.hm-carousel__slide');
  const totalSlides = slides.length;
  let currentIndex = 0;
  let interval = null;

  // Create dots
  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('button');
    dot.classList.add('hm-carousel__dot');
    if (i === 0) dot.classList.add('active');
    dot.dataset.index = i;
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
  }

  const dots = dotsContainer.querySelectorAll('.hm-carousel__dot');

  function goToSlide(index) {
    if (index < 0) index = totalSlides - 1;
    if (index >= totalSlides) index = 0;
    currentIndex = index;
    track.style.transform = `translateX(-${currentIndex * 100}%)`;
    dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
  }

  function nextSlide() {
    goToSlide(currentIndex + 1);
  }

  function startAutoPlay() {
    if (interval) clearInterval(interval);
    interval = setInterval(nextSlide, 3500);
  }

  function stopAutoPlay() {
    if (interval) clearInterval(interval);
    interval = null;
  }

  // Pause on hover (optional, but nice)
  const carousel = document.getElementById('heroCarousel');
  carousel.addEventListener('mouseenter', stopAutoPlay);
  carousel.addEventListener('mouseleave', startAutoPlay);

  // Touch/swipe support for mobile
  let touchStartX = 0;
  let touchEndX = 0;
  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });
  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    const diff = touchStartX - touchEndX;
    if (Math.abs(diff) > 40) {
      if (diff > 0) goToSlide(currentIndex + 1);
      else goToSlide(currentIndex - 1);
    }
  }, { passive: true });

  // Initialise
  goToSlide(0);
  startAutoPlay();
});
</script>

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
  --radius:  14px;
  --font-d:  'Fraunces', Georgia, serif;
  --font-b:  'Plus Jakarta Sans', system-ui, sans-serif;
  --max:     1200px;
  --pad:     clamp(20px, 5vw, 80px);
  --section: clamp(48px, 8vw, 100px);
}

html { -webkit-text-size-adjust: 100%; }
body { background: var(--cream); }
.hm-wrap { font-family: var(--font-b); color: var(--warm-dk); overflow-x: hidden; width: 100%; }

img { max-width: 100%; height: auto; display: block; }

/* ── Shared ── */
.hm-tag {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 0.72rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
  color: var(--warm-md); background: var(--peach-2);
  padding: 7px 16px; border-radius: 50px; margin-bottom: 22px;
}
.hm-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--coral); display:inline-block; flex-shrink: 0; }
.hm-tag--coral { color:var(--coral); background:rgba(212,80,26,0.10); }

.hm-section-title {
  font-family: var(--font-d);
  font-size: clamp(1.7rem, 4.5vw, 3.2rem);
  font-weight: 400; line-height: 1.2; color: var(--warm-dk); margin-bottom: 36px;
  word-wrap: break-word;
}
.hm-section-title em { font-style: italic; color: var(--coral); }
.hm-container { max-width: var(--max); margin: 0 auto; padding: var(--section) var(--pad); width: 100%; }

/* ── Buttons ── */
.hm-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  font-family: var(--font-b); font-size: 0.92rem; font-weight: 600;
  padding: 15px 30px; border-radius: 50px; cursor: pointer;
  text-decoration: none; border: none; transition: all 0.22s;
  min-height: 48px; /* touch target */
}
.hm-btn--primary { background: var(--coral); color: var(--white); box-shadow: 0 4px 20px rgba(212,80,26,0.28); }
.hm-btn--primary:hover { background: var(--coral-2); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(212,80,26,0.35); }
.hm-btn--outline { background: transparent; color: var(--coral); border: 1.5px solid rgba(212,80,26,0.4); }
.hm-btn--outline:hover { background: rgba(212,80,26,0.05); transform: translateY(-2px); border-color: var(--coral); }

/* ══════════════
   HERO
══════════════ */
.hm-hero {
  position: relative;
  background: var(--peach);
  overflow: hidden;
  min-height: 100vh;
  display: grid;
  grid-template-columns: 52% 48%;
  align-items: center;
}

.hm-watermark {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none; user-select: none;
  z-index: 0; text-align: center; white-space: nowrap;
  width: 100%; padding: 0 20px;
}
.hm-watermark span {
  display: block;
  font-family: var(--font-d);
  font-size: clamp(6rem, 20vw, 20rem);
  font-weight: 600; line-height: 0.88;
  letter-spacing: -0.02em;
  color: rgba(212, 80, 26, 0.055);
}

.hm-vignette {
  position: absolute; inset: 0; z-index: 1; pointer-events: none;
  background: radial-gradient(
    ellipse 55% 75% at 18% 50%,
    rgba(253,248,243,0.5) 0%,
    transparent 65%
  );
}

.hm-hero__left {
  position: relative; z-index: 2;
  padding: clamp(80px, 9vw, 130px) clamp(24px, 5vw, 90px);
  display: flex; flex-direction: column; justify-content: center;
  width: 100%;
}

.hm-hero__left::before {
  content: '';
  display: block;
  width: 44px; height: 3px;
  background: linear-gradient(90deg, var(--coral), var(--coral-2));
  border-radius: 2px;
  margin-bottom: 30px;
}

.hm-hero__left::after {
  content: '';
  position: absolute; right: 0; top: 14%; bottom: 14%;
  width: 1px; background: var(--peach-2);
}

.hm-hero__title {
  font-family: var(--font-d);
  font-size: clamp(2.4rem, 5.2vw, 5.6rem);
  font-weight: 400; line-height: 1.06;
  color: var(--warm-dk); margin-bottom: 28px;
  animation: fadeUp 0.65s ease both;
  word-wrap: break-word;
}
.hm-hero__title em { font-style: italic; color: var(--coral); }

.hm-hero__sub {
  font-size: clamp(0.9rem, 1.5vw, 1.08rem);
  color: var(--warm-md); line-height: 1.8; font-weight: 300;
  max-width: 400px; margin-bottom: 40px;
  animation: fadeUp 0.65s 0.1s ease both;
}

.hm-hero__btns {
  display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 52px;
  animation: fadeUp 0.65s 0.18s ease both;
}

.hm-stats {
  display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
  animation: fadeUp 0.65s 0.26s ease both;
}
.hm-stat { display: flex; flex-direction: column; gap: 3px; }
.hm-stat__num {
  font-family: var(--font-d);
  font-size: 1.6rem; font-weight: 600;
  color: var(--warm-dk); line-height: 1;
}
.hm-stat__lbl {
  font-size: 0.74rem; font-weight: 500;
  color: var(--warm-lt); letter-spacing: 0.07em; text-transform: uppercase;
  white-space: nowrap;
}
.hm-stat__div { width: 1px; height: 38px; background: var(--peach-2); flex-shrink: 0; }

/* ── Carousel ── */
.hm-hero__right {
  position: relative; z-index: 2;
  height: 100%; min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}

.hm-carousel {
  width: 100%;
  height: 100%;
  position: relative;
  overflow: hidden;
}

.hm-carousel__track {
  display: flex;
  width: 100%;
  height: 100%;
  transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.hm-carousel__slide {
  flex: 0 0 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hm-carousel__slide img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center center;
  filter: drop-shadow(0 28px 56px rgba(61,43,31,0.13));
  transition: transform 0.55s ease, filter 0.4s ease;
}

.hm-carousel__slide img:hover {
  transform: scale(1.02);
  filter: drop-shadow(0 40px 72px rgba(61,43,31,0.17));
}

.hm-carousel__dots {
  position: absolute;
  bottom: 24px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
  z-index: 5;
}

.hm-carousel__dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: rgba(255,255,255,0.5);
  border: none;
  cursor: pointer;
  padding: 0;
  transition: background 0.25s, transform 0.2s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.hm-carousel__dot.active {
  background: var(--coral);
  transform: scale(1.25);
}

.hm-carousel__dot:hover {
  background: var(--coral-2);
  transform: scale(1.15);
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes carSlide {
  from { opacity: 0; transform: translateX(70px); }
  to   { opacity: 1; transform: translateX(0); }
}

/* ── Search ── */
.hm-search { background: var(--cream); border-top: 1px solid var(--peach-2); }
.hm-search__form { display: flex; flex-wrap: wrap; gap: 12px; max-width: 680px; }
.hm-search__input {
  flex: 1; min-width: 220px; padding: 15px 20px;
  border: 1.5px solid var(--peach-2); border-radius: 50px;
  font-size: 0.95rem; font-family: var(--font-b);
  background: var(--white); color: var(--warm-dk);
  transition: border-color 0.2s, box-shadow 0.2s;
  min-height: 48px;
}
.hm-search__input:focus { outline: none; border-color: var(--coral); box-shadow: 0 0 0 3px rgba(212,80,26,0.12); }
.hm-search__input::placeholder { color: var(--warm-lt); }
.hm-search__btn { white-space: nowrap; }

/* ── Filters ── */
.hm-filters { background: var(--peach); border-top: 1px solid var(--peach-2); }
.hm-filter-block { margin-bottom: 52px; }

.hm-price-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
  gap: 10px; max-width: 900px;
}
.hm-price-btn {
  padding: 13px 16px; font-family: var(--font-b); font-size: 0.88rem; font-weight: 600;
  background: var(--white); color: var(--warm-dk);
  border: 1.5px solid var(--peach-2); border-radius: var(--radius);
  cursor: pointer; transition: all 0.2s; white-space: nowrap;
  min-height: 46px;
}
.hm-price-btn:hover { background: var(--coral); color: var(--white); border-color: var(--coral); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(212,80,26,0.22); }
.hm-price-btn--accent { background: rgba(212,80,26,0.07); color: var(--coral); border-color: rgba(212,80,26,0.25); }

.hm-select-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 700px; margin-bottom: 48px; }
.hm-select-label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--warm-dk); margin-bottom: 8px; letter-spacing: 0.04em; text-transform: uppercase; }
.hm-select {
  width: 100%; padding: 13px 16px;
  border: 1.5px solid var(--peach-2); border-radius: var(--radius);
  font-size: 0.93rem; font-family: var(--font-b);
  background: var(--white); color: var(--warm-dk);
  cursor: pointer; appearance: none;
  transition: border-color 0.2s, box-shadow 0.2s;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23b89b8a' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
  min-height: 48px;
}
.hm-select:focus { outline: none; border-color: var(--coral); box-shadow: 0 0 0 3px rgba(212,80,26,0.12); }
.hm-filter-cta { text-align: left; }

/* ── Responsive ── */

/* Tablet / small laptop */
@media (max-width: 1024px) {
  .hm-hero__left { padding-left: clamp(24px, 4vw, 60px); padding-right: clamp(24px, 4vw, 60px); }
  .hm-hero__title { font-size: clamp(2.2rem, 5vw, 4rem); }
  .hm-price-grid { grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); }
}

/* Stack hero, single column layout */
@media (max-width: 900px) {
  .hm-hero { grid-template-columns: 1fr; min-height: auto; }
  .hm-hero__left { padding: 90px var(--pad) 32px; }
  .hm-hero__left::after { display: none; }
  .hm-hero__right { min-height: 56vw; height: 56vw; }
  .hm-select-row { grid-template-columns: 1fr 1fr; }
}

/* Small tablet / large phone */
@media (max-width: 700px) {
  .hm-section-title { font-size: clamp(1.6rem, 6vw, 2.4rem); margin-bottom: 26px; }
  .hm-container { padding: var(--section) var(--pad); }
  .hm-select-row { grid-template-columns: 1fr; max-width: 100%; margin-bottom: 36px; }
  .hm-price-grid { grid-template-columns: repeat(2, 1fr); }
  .hm-hero__sub { max-width: 100%; }
}

/* Phones */
@media (max-width: 600px) {
  .hm-hero__left { padding-top: 76px; }
  .hm-hero__title { font-size: clamp(2rem, 8vw, 2.6rem); }
  .hm-hero__btns { flex-direction: column; max-width: 100%; }
  .hm-btn { width: 100%; }
  .hm-search__form { flex-direction: column; }
  .hm-search__input { min-width: 0; width: 100%; }
  .hm-search__btn { width: 100%; }
  .hm-price-grid { grid-template-columns: repeat(2,1fr); gap: 8px; }
  .hm-price-btn { font-size: 0.82rem; padding: 12px 10px; }
  .hm-stats { gap: 14px; row-gap: 10px; }
  .hm-stat__num { font-size: 1.3rem; }
  .hm-stat__lbl { font-size: 0.66rem; }
  .hm-stat__div { height: 32px; }
  .hm-watermark span { font-size: clamp(4rem, 24vw, 7rem); }
  .hm-hero__right { min-height: 62vw; height: 62vw; }
}

/* Very small phones */
@media (max-width: 400px) {
  .hm-price-grid { grid-template-columns: 1fr; }
  .hm-tag { font-size: 0.65rem; padding: 6px 12px; }
  .hm-hero__title { font-size: 1.8rem; }
  .hm-watermark span { font-size: clamp(3rem, 22vw, 5.5rem); }
}

/* Landscape phones with limited height */
@media (max-height: 480px) and (orientation: landscape) {
  .hm-hero { min-height: auto; }
  .hm-hero__left { padding-top: 60px; padding-bottom: 40px; }
  .hm-hero__right { min-height: 260px; height: 260px; }
}

/* Larger desktop screens: keep things from stretching too thin */
@media (min-width: 1600px) {
  .hm-container { padding-left: 0; padding-right: 0; }
}
</style>

@endsection
