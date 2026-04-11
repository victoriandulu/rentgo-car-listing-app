@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,400;1,9..144,500;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="hm-wrap">

  {{-- ── Hero ── --}}
  <section class="hm-hero">

    {{-- Watermark --}}
    <div class="hm-watermark" aria-hidden="true">
      <span>Rent</span>
      <span>Go</span>
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

    {{-- Right: Car --}}
    <div class="hm-hero__right">
      <img src="{{ asset('images/gwagon.png') }}" alt="Featured Vehicle" />
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
      // Empty search → just go to /vehicles with no query param
      e.preventDefault();
      window.location.href = '{{ url('/vehicles') }}';
      return;
    }
    // Non-empty: let the form submit normally to /vehicles?query=...
    // The vehicles page controller reads $_GET['query'] and filters results
  });
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
  --pad:     clamp(24px, 5vw, 80px);
  --section: clamp(60px, 8vw, 100px);
}

body { background: var(--cream); }
.hm-wrap { font-family: var(--font-b); color: var(--warm-dk); overflow-x: hidden; }

/* ── Shared ── */
.hm-tag {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 0.72rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
  color: var(--warm-md); background: var(--peach-2);
  padding: 7px 16px; border-radius: 50px; margin-bottom: 22px;
}
.hm-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--coral); display:inline-block; }
.hm-tag--coral { color:var(--coral); background:rgba(212,80,26,0.10); }

.hm-section-title {
  font-family: var(--font-d);
  font-size: clamp(2rem, 4.5vw, 3.2rem);
  font-weight: 400; line-height: 1.2; color: var(--warm-dk); margin-bottom: 36px;
}
.hm-section-title em { font-style: italic; color: var(--coral); }
.hm-container { max-width: var(--max); margin: 0 auto; padding: var(--section) var(--pad); }

/* ── Buttons ── */
.hm-btn {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: var(--font-b); font-size: 0.92rem; font-weight: 600;
  padding: 15px 30px; border-radius: 50px; cursor: pointer;
  text-decoration: none; border: none; transition: all 0.22s;
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
}
.hm-watermark span {
  display: block;
  font-family: var(--font-d);
  font-size: clamp(9rem, 22vw, 20rem);
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
  padding: clamp(80px, 9vw, 130px) clamp(32px, 5vw, 90px);
  display: flex; flex-direction: column; justify-content: center;
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
  font-size: clamp(3rem, 5.2vw, 5.6rem);
  font-weight: 400; line-height: 1.06;
  color: var(--warm-dk); margin-bottom: 28px;
  animation: fadeUp 0.65s ease both;
}
.hm-hero__title em { font-style: italic; color: var(--coral); }

.hm-hero__sub {
  font-size: clamp(0.95rem, 1.5vw, 1.08rem);
  color: var(--warm-md); line-height: 1.8; font-weight: 300;
  max-width: 400px; margin-bottom: 40px;
  animation: fadeUp 0.65s 0.1s ease both;
}

.hm-hero__btns {
  display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 52px;
  animation: fadeUp 0.65s 0.18s ease both;
}

.hm-stats {
  display: flex; align-items: center; gap: 24px;
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
}
.hm-stat__div { width: 1px; height: 38px; background: var(--peach-2); flex-shrink: 0; }

.hm-hero__right {
  position: relative; z-index: 2;
  height: 100%; min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.hm-hero__right img {
  width: 110%; height: 100%;
  object-fit: contain; object-position: center center;
  transform: translateY(-2%) translateX(4%);
  filter: drop-shadow(0 28px 56px rgba(61,43,31,0.13));
  animation: carSlide 0.9s 0.12s cubic-bezier(0.22,1,0.36,1) both;
  transition: transform 0.55s ease, filter 0.4s ease;
}
.hm-hero__right img:hover {
  transform: translateY(-4%) translateX(4%) scale(1.02);
  filter: drop-shadow(0 40px 72px rgba(61,43,31,0.17));
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes carSlide {
  from { opacity: 0; transform: translateY(-2%) translateX(70px); }
  to   { opacity: 1; transform: translateY(-2%) translateX(4%); }
}

/* ── Search ── */
.hm-search { background: var(--cream); border-top: 1px solid var(--peach-2); }
.hm-search__form { display: flex; gap: 12px; max-width: 680px; }
.hm-search__input {
  flex: 1; padding: 15px 20px;
  border: 1.5px solid var(--peach-2); border-radius: 50px;
  font-size: 0.95rem; font-family: var(--font-b);
  background: var(--white); color: var(--warm-dk);
  transition: border-color 0.2s, box-shadow 0.2s;
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
}
.hm-select:focus { outline: none; border-color: var(--coral); box-shadow: 0 0 0 3px rgba(212,80,26,0.12); }
.hm-filter-cta { text-align: left; }

/* ── Responsive ── */
@media (max-width: 900px) {
  .hm-hero { grid-template-columns: 1fr; min-height: auto; }
  .hm-hero__left { padding: 90px var(--pad) 32px; }
  .hm-hero__left::after { display: none; }
  .hm-hero__right { min-height: 56vw; height: 56vw; }
  .hm-hero__right img { transform: none; width: 100%; }
}
@media (max-width: 600px) {
  .hm-hero__btns { flex-direction: column; max-width: 280px; }
  .hm-btn { width: 100%; justify-content: center; }
  .hm-search__form { flex-direction: column; }
  .hm-search__btn { width: 100%; justify-content: center; }
  .hm-price-grid { grid-template-columns: repeat(2,1fr); }
  .hm-stats { gap: 14px; }
  .hm-stat__num { font-size: 1.3rem; }
  .hm-select-row { grid-template-columns: 1fr; max-width: 100%; }
  .hm-watermark span { font-size: clamp(6rem, 28vw, 10rem); }
}
@media (max-width: 400px) {
  .hm-price-grid { grid-template-columns: 1fr; }
}
</style>

@endsection
