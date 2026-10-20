@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

@php
  // Slides are managed in Admin → Home Slides. If the table is empty (or the
  // description column is not migrated yet) the built-in cars are shown instead.
  try { $heroSlides = \App\Models\HeroSlide::active()->get(); }
  catch (\Throwable $e) { $heroSlides = collect(); }
@endphp

<div class="hm-wrap">
  <section class="hm-hero">

    {{-- Car carousel (right side, fades into the cream) --}}
    <div class="hm-carousel" id="heroCarousel" aria-label="Featured vehicles">

      {{-- Hilly landscape behind the cars (lightweight drawn version) --}}
      <svg class="hm-hills" viewBox="0 0 1000 600" preserveAspectRatio="xMidYMax slice" aria-hidden="true">
        <defs>
          <linearGradient id="hmSky" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#F1CDB4"/><stop offset=".5" stop-color="#F7E1CC"/><stop offset="1" stop-color="#F7EBDD"/></linearGradient>
          <radialGradient id="hmSun" cx=".8" cy=".16" r=".5"><stop offset="0" stop-color="#FFF1BF" stop-opacity=".95"/><stop offset="1" stop-color="#FFF1BF" stop-opacity="0"/></radialGradient>
          <linearGradient id="hmFar" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#DDB9A0"/><stop offset="1" stop-color="#F1DDCB"/></linearGradient>
          <linearGradient id="hmMid" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#B26E45"/><stop offset=".6" stop-color="#D49A70"/><stop offset="1" stop-color="#EBC7A6"/></linearGradient>
          <linearGradient id="hmNear" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#9D5A33"/><stop offset="1" stop-color="#C98B63"/></linearGradient>
          <linearGradient id="hmGround" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#CE9467"/><stop offset=".4" stop-color="#B97D52"/><stop offset="1" stop-color="#8C4F30"/></linearGradient>
        </defs>
        <rect width="1000" height="600" fill="url(#hmSky)"/>
        <rect width="1000" height="600" fill="url(#hmSun)"/>
        <path d="M0 310 C120 300 220 290 340 270 C460 250 560 245 680 210 C780 180 860 140 1000 150 L1000 700 L0 700Z" fill="url(#hmFar)"/>
        <path d="M0 360 C140 372 240 376 340 366 C440 340 540 310 640 262 C740 210 840 160 1000 175 L1000 700 L0 700Z" fill="url(#hmMid)"/>
        <path d="M0 384 C140 380 260 376 380 378 C500 366 620 345 740 290 C840 262 920 252 1000 270 L1000 700 L0 700Z" fill="url(#hmNear)"/>
        <path d="M0 408 C200 408 320 404 500 404 C700 406 860 406 1000 408 L1000 700 L0 700Z" fill="url(#hmGround)"/>
        <g fill="#5E4E2C" opacity=".5">
          <ellipse cx="540" cy="438" rx="9" ry="5"/><ellipse cx="560" cy="432" rx="8" ry="4.5"/>
          <ellipse cx="660" cy="430" rx="9" ry="5"/><ellipse cx="620" cy="448" rx="8" ry="4.5"/>
          <ellipse cx="820" cy="450" rx="10" ry="6"/><ellipse cx="940" cy="455" rx="9" ry="5"/>
          <ellipse cx="512" cy="462" rx="8" ry="4.5"/><ellipse cx="400" cy="404" rx="6" ry="3.5"/>
        </g>
      </svg>

      {{-- Optional photo: save a photo as public/images/hills.jpg and it replaces the drawn hills --}}
      <img class="hm-hills-photo" src="{{ asset('images/hills.jpg') }}" alt="" onerror="this.remove()" />

      <div class="hm-carousel__track" id="carouselTrack">
        @forelse($heroSlides as $slide)
          @php
            $slideTitle = $slide->title ?? null;
            $slideDesc  = $slide->description ?? null;
          @endphp
          <div class="hm-carousel__slide">
            <div class="hm-carousel__img">
              @if(filled($slide->link_url))
                <a href="{{ $slide->link_url }}"><img src="{{ $slide->image_url }}" alt="{{ $slideTitle ?: 'Featured vehicle' }}" /></a>
              @else
                <img src="{{ $slide->image_url }}" alt="{{ $slideTitle ?: 'Featured vehicle' }}" />
              @endif
            </div>
            @if(filled($slideTitle) || filled($slideDesc))
              <div class="hm-carousel__caption">
                @if(filled($slideTitle))<h3>{{ $slideTitle }}</h3>@endif
                @if(filled($slideDesc))<p>{{ $slideDesc }}</p>@endif
              </div>
            @endif
          </div>
        @empty
          @foreach([
            ['gwagon.png', 'Mercedes G-Wagon', 'Iconic luxury SUV with unmatched road presence.'],
            ['Luxury_Sedan.png', 'Luxury Sedan', 'Comfort, style and refinement for every journey.'],
            ['Sports_Coupe.png', 'Sports Coupe', 'Sharp looks and thrilling performance.'],
            ['Electric_SUV.png', 'Electric SUV', 'Quiet, clean and powerful family driving.'],
            ['Offroad_Pickup.png', 'Offroad Pickup', 'Built tough for work and weekend adventures.'],
            ['Compact_Hatchback.png', 'Compact Hatchback', 'Smart, efficient and easy to park.'],
          ] as $fallback)
            <div class="hm-carousel__slide">
              <div class="hm-carousel__img"><img src="{{ asset('images/' . $fallback[0]) }}" alt="{{ $fallback[1] }}" /></div>
              <div class="hm-carousel__caption">
                <h3>{{ $fallback[1] }}</h3>
                <p>{{ $fallback[2] }}</p>
              </div>
            </div>
          @endforeach
        @endforelse
      </div>
      <div class="hm-carousel__dots" id="carouselDots"></div>
    </div>

    <div class="hm-hero__content">
      <span class="hm-tag">Find your perfect car</span>

      <h1 class="hm-hero__title">What's your <em>budget?</em></h1>
      <p class="hm-hero__sub">Quality cars. Fair prices. Delivered to you.</p>

      {{-- Type your budget --}}
      <form class="hm-budget" id="budgetForm" autocomplete="off" novalidate>
        <input type="text" id="budgetInput" inputmode="text" placeholder="Type your budget e.g. 1.5M, 800K or 1M - 2M" aria-label="Your budget" />
        <button type="submit">Search</button>
      </form>
      <p class="hm-budget__err" id="budgetErr" hidden>Please enter a valid amount, like 1.5M, 800000 or 1M - 2M.</p>

      <div class="hm-price-row" role="group" aria-label="Filter by price">
        <button type="button" class="hm-price-btn" data-min="0" data-max="500000">Under 500K</button>
        <button type="button" class="hm-price-btn" data-min="500000" data-max="1000000">500K – 1M</button>
        <button type="button" class="hm-price-btn" data-min="1000000" data-max="2000000">1M – 2M</button>
        <button type="button" class="hm-price-btn" data-min="2000000" data-max="3000000">2M – 3M</button>
        <button type="button" class="hm-price-btn" data-min="3000000" data-max="5000000">3M – 5M</button>
        <button type="button" class="hm-price-btn" data-min="5000000" data-max="10000000">5M – 10M</button>
        <button type="button" class="hm-price-btn hm-price-btn--accent" data-min="10000000" data-max="999999999">Above 10M</button>
      </div>

      <div class="hm-select-row">
        <select id="brand-filter" class="hm-select" aria-label="Filter by brand">
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
        <select id="body-filter" class="hm-select" aria-label="Filter by body type">
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

      <a href="{{ url('/vehicles') }}" class="hm-btn">View All Vehicles →</a>
    </div>

  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var VEHICLES_URL = @json(url('/vehicles'));

  /* ---------- Filters ---------- */
  document.querySelectorAll('.hm-price-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.location.href = VEHICLES_URL + '?price_min=' + btn.dataset.min + '&price_max=' + btn.dataset.max;
    });
  });
  document.getElementById('brand-filter').addEventListener('change', function () {
    if (this.value) window.location.href = VEHICLES_URL + '?make=' + encodeURIComponent(this.value);
  });
  document.getElementById('body-filter').addEventListener('change', function () {
    if (this.value) window.location.href = VEHICLES_URL + '?body_type=' + encodeURIComponent(this.value);
  });

  /* ---------- Typed budget ---------- */
  function parseAmount(s) {
    s = (s || '').toLowerCase().replace(/ksh|kes|shs|sh/g, '').replace(/[,\s]/g, '');
    var m = s.match(/^(\d+(?:\.\d+)?)(k|m)?$/);
    if (!m) return null;
    var n = parseFloat(m[1]);
    if (m[2] === 'k') n *= 1000;
    if (m[2] === 'm') n *= 1000000;
    return Math.round(n);
  }
  document.getElementById('budgetForm').addEventListener('submit', function (e) {
    e.preventDefault();
    var raw = document.getElementById('budgetInput').value.toLowerCase();
    var err = document.getElementById('budgetErr');
    var parts = raw.replace(/–|—|\bto\b/g, '-').split('-').filter(function (p) { return p.trim() !== ''; });
    var min = 0, max = null;
    if (parts.length === 1) {
      max = parseAmount(parts[0]);
    } else if (parts.length === 2) {
      min = parseAmount(parts[0]);
      max = parseAmount(parts[1]);
      if (min !== null && max !== null && min > max) { var t = min; min = max; max = t; }
    }
    if (max === null || min === null || max <= 0) { err.hidden = false; return; }
    err.hidden = true;
    window.location.href = VEHICLES_URL + '?price_min=' + min + '&price_max=' + max;
  });

  /* ---------- Carousel ---------- */
  var track = document.getElementById('carouselTrack');
  var dotsBox = document.getElementById('carouselDots');
  var carousel = document.getElementById('heroCarousel');
  var total = track.children.length;
  var index = 0, timer = null;

  function go(i) {
    index = (i + total) % total;
    track.style.transform = 'translateX(-' + (index * 100) + '%)';
    Array.prototype.forEach.call(dotsBox.children, function (d, n) {
      d.classList.toggle('active', n === index);
    });
  }
  function stop()  { if (timer) clearInterval(timer); timer = null; }
  function start() { stop(); if (total > 1) timer = setInterval(function () { go(index + 1); }, 4000); }

  if (total > 1) {
    for (var i = 0; i < total; i++) {
      (function (n) {
        var d = document.createElement('button');
        d.type = 'button';
        d.className = 'hm-carousel__dot' + (n === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Slide ' + (n + 1));
        d.addEventListener('click', function () { go(n); start(); });
        dotsBox.appendChild(d);
      })(i);
    }
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);

    var x0 = 0;
    track.addEventListener('touchstart', function (e) { x0 = e.changedTouches[0].screenX; }, { passive: true });
    track.addEventListener('touchend', function (e) {
      var diff = x0 - e.changedTouches[0].screenX;
      if (Math.abs(diff) > 40) { go(index + (diff > 0 ? 1 : -1)); start(); }
    }, { passive: true });
  }

  /* ---------- Stretch hero down to the footer (no blank band) ---------- */
  var hero = document.querySelector('.hm-hero');
  var wrap = document.querySelector('.hm-wrap');
  function findFooter() {
    var f = document.querySelector('footer');
    if (f) return f;
    var hits = Array.prototype.filter.call(
      document.body.querySelectorAll('div,p,span,small,section'),
      function (el) { return !el.contains(hero) && /rights reserved/i.test(el.textContent); }
    );
    if (!hits.length) return null;
    f = hits.reduce(function (a, b) { return a.textContent.length <= b.textContent.length ? a : b; });
    while (f.parentElement && !f.parentElement.contains(hero)) f = f.parentElement;
    return f;
  }
  function fillGap() {
    hero.style.minHeight = '';
    wrap.style.marginBottom = '';
    if (window.innerWidth <= 800) return;
    var f = findFooter();
    if (!f) return;
    var gap = f.getBoundingClientRect().top - hero.getBoundingClientRect().bottom;
    if (gap > 0 && gap < 500) {
      hero.style.minHeight = (hero.offsetHeight + gap) + 'px';
      wrap.style.marginBottom = (-gap) + 'px';
    }
  }
  fillGap();
  window.addEventListener('load', fillGap);
  window.addEventListener('resize', fillGap);
  setTimeout(fillGap, 400);
  setTimeout(fillGap, 1200);

  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) start();
});
</script>

<style>
:root {
  --cream:#F5EBDD; --espresso:#3A2920; --orange:#D94F16; --yellow:#F5C400;
  --terracotta:#B94314; --beige:#EAD9C6; --peach:#F3D7C8;
  --font-d:'Playfair Display',Georgia,serif; --font-b:'Inter',system-ui,sans-serif;
  --pad:clamp(20px,5vw,80px);
}
.hm-wrap, .hm-wrap *, .hm-wrap *::before, .hm-wrap *::after { box-sizing:border-box; }
.hm-wrap { font-family:var(--font-b); color:var(--espresso); background:var(--cream); width:100%; overflow-x:hidden; }
.hm-wrap h1, .hm-wrap h3, .hm-wrap p { margin:0; }

/* Hero */
.hm-hero { position:relative; display:flex; align-items:center; min-height:max(640px,calc(100vh - 110px)); min-height:max(640px,calc(100dvh - 110px)); background:var(--cream); overflow:hidden; }
.hm-hero__content { position:relative; z-index:2; width:100%; max-width:720px; padding:clamp(72px,9vw,110px) var(--pad) clamp(48px,6vw,72px); }

.hm-tag {
  display:inline-flex; align-items:center; gap:8px; margin-bottom:26px;
  font-size:.66rem; font-weight:600; letter-spacing:.14em; text-transform:uppercase;
  background:var(--peach); padding:8px 15px; border-radius:50px;
}
.hm-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--orange); }

.hm-hero__title { font-family:var(--font-d); font-size:clamp(2.3rem,4.6vw,3.7rem); font-weight:600; line-height:1.1; margin-bottom:18px; }
.hm-hero__title em { font-style:italic; color:var(--orange); }
.hm-hero__sub { font-size:clamp(.95rem,1.5vw,1.1rem); opacity:.78; margin-bottom:24px; }

/* Typed budget */
.hm-budget { display:flex; gap:10px; max-width:600px; margin-bottom:18px; }
.hm-budget input {
  flex:1; min-width:0; min-height:48px; padding:12px 18px;
  font:500 .9rem var(--font-b); color:var(--espresso); background:#fff;
  border:1px solid var(--beige); border-radius:50px; box-shadow:0 2px 8px rgba(58,41,32,.06);
}
.hm-budget button {
  min-height:48px; padding:0 26px; border:0; border-radius:50px;
  background:var(--orange); color:#fff; font:600 .9rem var(--font-b); cursor:pointer; transition:.18s;
}
.hm-budget button:hover { background:var(--terracotta); }
.hm-budget__err { color:var(--terracotta); font-size:.8rem; margin:-8px 0 14px; }
.hm-budget__err[hidden] { display:none; }

.hm-price-row { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px; max-width:600px; }
.hm-price-btn {
  font:600 .76rem var(--font-b); color:var(--espresso); background:#fff;
  border:1px solid var(--beige); border-radius:12px; padding:11px 14px; min-height:42px;
  cursor:pointer; box-shadow:0 2px 8px rgba(58,41,32,.06); transition:.18s;
}
.hm-price-btn:hover { background:var(--orange); color:#fff; border-color:var(--orange); }
.hm-price-btn--accent { background:var(--peach); color:var(--orange); border-color:var(--orange); }

.hm-select-row { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:28px; }
.hm-select {
  width:190px; max-width:100%; min-height:44px; padding:11px 36px 11px 14px;
  font:500 .8rem var(--font-b); color:var(--espresso); background-color:#fff;
  border:1px solid var(--beige); border-radius:10px; box-shadow:0 2px 8px rgba(58,41,32,.06);
  appearance:none; -webkit-appearance:none; cursor:pointer;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%233A2920' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
  background-repeat:no-repeat; background-position:right 12px center;
}
.hm-btn {
  display:inline-flex; align-items:center; justify-content:center; min-height:48px;
  padding:14px 30px; border-radius:50px; background:var(--orange); color:#fff;
  font:600 .9rem var(--font-b); text-decoration:none; box-shadow:0 6px 20px rgba(217,79,22,.3); transition:.2s;
}
.hm-btn:hover { background:var(--terracotta); color:#fff; transform:translateY(-2px); }
.hm-price-btn:focus-visible, .hm-select:focus-visible, .hm-btn:focus-visible,
.hm-budget input:focus-visible, .hm-budget button:focus-visible, .hm-carousel__dot:focus-visible { outline:3px solid var(--yellow); outline-offset:2px; }

/* Carousel – right side, fades into cream */
.hm-carousel {
  position:absolute; top:0; right:0; bottom:0; width:54%; overflow:hidden;
  -webkit-mask-image:linear-gradient(to right,transparent 0%,#000 22%);
          mask-image:linear-gradient(to right,transparent 0%,#000 22%);
}
.hm-hills-photo { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center bottom; z-index:0; }
.hm-hills { position:absolute; inset:0; width:100%; height:100%; z-index:0; }
.hm-carousel__track { position:relative; z-index:1; display:flex; height:100%; transition:transform .6s cubic-bezier(.25,.46,.45,.94); }

.hm-carousel__slide {
  position:relative; flex:0 0 100%; min-width:0; height:100%;
  display:flex; flex-direction:column; align-items:center;
  padding:80px 6% 48px; gap:14px;
}
.hm-carousel__img {
  position:relative; flex:1 1 auto; min-height:0; width:100%;
  display:flex; align-items:flex-end; justify-content:center;
}
.hm-carousel__img::after {
  content:''; position:absolute; left:14%; right:14%; bottom:-6px; height:22px;
  background:radial-gradient(ellipse at center,rgba(45,22,10,.5),transparent 70%); filter:blur(5px); z-index:0;
}
.hm-carousel__img a { position:relative; z-index:1; display:flex; align-items:flex-end; justify-content:center; width:100%; height:100%; }
.hm-carousel__img img { position:relative; z-index:1; max-width:100%; max-height:100%; width:auto; height:auto; object-fit:contain; object-position:center bottom; }

.hm-carousel__caption {
  position:relative; z-index:2; flex:0 0 auto; width:min(100%,460px); text-align:center;
  background:rgba(255,248,238,.93); border-radius:14px; padding:12px 18px;
  box-shadow:0 6px 18px rgba(58,41,32,.18);
}
.hm-carousel__caption h3 { font:600 1.1rem/1.25 var(--font-d); color:var(--espresso); margin-bottom:4px; }
.hm-carousel__caption p {
  font-size:.84rem; line-height:1.45; opacity:.85;
  display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
}

.hm-carousel__dots { position:absolute; bottom:16px; left:50%; transform:translateX(-50%); display:flex; flex-wrap:wrap; justify-content:center; gap:8px; max-width:90%; z-index:3; }
.hm-carousel__dot { width:10px; height:10px; padding:0; border:none; border-radius:50%; background:rgba(58,41,32,.3); cursor:pointer; transition:.2s; }
.hm-carousel__dot.active { background:var(--orange); transform:scale(1.25); }

/* Tablet / mobile */
@media (max-width:800px) {
  .hm-hero { flex-direction:column; align-items:stretch; min-height:0; }
  .hm-hero__content { order:1; padding-bottom:0; }
  .hm-carousel {
    position:relative; order:2; width:100%; height:auto; top:auto; right:auto; bottom:auto;
    -webkit-mask-image:linear-gradient(to bottom,transparent 0%,#000 18%);
            mask-image:linear-gradient(to bottom,transparent 0%,#000 18%);
  }
  .hm-carousel__track { height:auto; }
  .hm-carousel__slide { height:auto; padding:48px 5% 44px; }
  .hm-carousel__img { flex:none; height:52vw; min-height:200px; }
}
@media (max-width:600px) {
  .hm-price-btn { flex:1 1 calc(50% - 8px); }
  .hm-select { width:100%; }
  .hm-btn { width:100%; }
  .hm-budget { flex-direction:column; }
  .hm-budget button { width:100%; }
}
@media (prefers-reduced-motion:reduce) { .hm-wrap * { transition:none !important; } }
</style>

@endsection
