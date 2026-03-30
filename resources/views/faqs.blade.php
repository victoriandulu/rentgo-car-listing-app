@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,500&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<div class="fq-wrap">

  {{-- Hero --}}
  <section class="fq-hero">
    <div class="fq-hero__deco"></div>
    <div class="fq-hero__inner">
      <span class="fq-tag">Help Centre</span>
      <h1 class="fq-hero__title">Frequently asked <em>questions.</em></h1>
      <p class="fq-hero__sub">Everything you need to know about our premium vehicle services and rental experience.</p>
    </div>
  </section>

  {{-- FAQ List --}}
  <section class="fq-body">
    <div class="fq-list">

      @php
        $faqs = [
          ["Do you offer both new and pre-owned vehicles?", "Yes, we provide a selection of both brand-new and certified used cars to meet diverse customer needs."],
          ["What are the origins of your imported vehicles?", "Our cars are sourced from reputable suppliers and dealerships across the globe, ensuring wide variety and high quality in our offerings."],
          ["Are financing options available for car purchases?", "We accommodate both cash payments and bank-assisted asset financing. Currently, we do not provide hire purchase arrangements."],
          ["Is it possible to trade in my existing vehicle?", "Yes, we facilitate trade-ins and offer fair market value assessments to ensure a smooth transition to your next vehicle."],
          ["What does your warranty cover?", "Our comprehensive warranty covers mechanical and electrical components for 12 months or 20,000 kilometres, whichever comes first — including engine, transmission, steering, and braking systems."],
          ["How long does the import process take?", "The import process usually takes 4–6 weeks from order confirmation to delivery. Custom or specialty vehicles may require additional time. We provide regular updates throughout."],
          ["Do you offer vehicle customisation services?", "Yes, we provide a range of customisation options including interior upgrades, performance enhancements, and exterior modifications. Our specialists can tailor a vehicle to your exact preferences."],
          ["What documentation is required to purchase?", "You'll need a valid ID (passport or national ID), proof of address, and a tax compliance certificate. For financing, additional documentation from your bank may be required."],
          ["Do you offer after-sales service and maintenance?", "Absolutely. We have a state-of-the-art service centre with certified technicians for all maintenance and repair needs. Service packages can also be included with your purchase."],
          ["Can I test drive before making a decision?", "Yes — we encourage test drives to ensure your complete satisfaction. Book an appointment online or call us to arrange a test drive of any vehicle in our inventory."],
        ];
      @endphp

      @foreach($faqs as $index => $faq)
      <div class="fq-item" onclick="toggleFAQ({{ $index }})">
        <div class="fq-item__q">
          <span class="fq-item__num">{{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}</span>
          <span class="fq-item__text">{{ $faq[0] }}</span>
          <button class="fq-item__toggle" id="icon-{{ $index }}" aria-label="Toggle">
            <span class="fq-item__plus">+</span>
          </button>
        </div>
        <div class="fq-item__a" id="answer-{{ $index }}">
          <p>{{ $faq[1] }}</p>
        </div>
      </div>
      @endforeach

    </div>

    {{-- Sidebar --}}
    <aside class="fq-sidebar">
      <div class="fq-sidebar__card">
        <div class="fq-sidebar__icon">💬</div>
        <h3 class="fq-sidebar__title">Still have questions?</h3>
        <p class="fq-sidebar__body">Our expert team is ready to help you find the perfect vehicle solution.</p>
        <a href="tel:+254717475336" class="fq-btn">📞 Call Us Now</a>
        <a href="{{ route('contact') ?? '#' }}" class="fq-btn fq-btn--outline">Send a Message</a>
      </div>
      <div class="fq-sidebar__hours">
        <p class="fq-sidebar__hours-title">Office Hours</p>
        <p>Mon – Fri: 9AM – 6PM</p>
        <p>Sat: 10AM – 4PM</p>
        <p>Sun: Closed</p>
      </div>
    </aside>

  </section>

</div>

<script>
function toggleFAQ(index) {
  const items   = document.querySelectorAll('.fq-item');
  const item    = items[index];
  const answer  = document.getElementById('answer-' + index);
  const icon    = document.getElementById('icon-' + index);
  const isOpen  = item.classList.contains('fq-item--open');

  // close all
  items.forEach((el, i) => {
    el.classList.remove('fq-item--open');
    document.getElementById('answer-' + i).style.maxHeight = null;
    document.getElementById('icon-' + i).querySelector('.fq-item__plus').textContent = '+';
  });

  if (!isOpen) {
    item.classList.add('fq-item--open');
    answer.style.maxHeight = answer.scrollHeight + 'px';
    icon.querySelector('.fq-item__plus').textContent = '−';
  }
}
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
  --radius:  16px;
  --font-d:  'Fraunces', Georgia, serif;
  --font-b:  'Plus Jakarta Sans', system-ui, sans-serif;
  --max:     1100px;
  --pad:     clamp(24px, 6vw, 80px);
  --section: clamp(60px, 8vw, 100px);
}

body { background: var(--cream); }
.fq-wrap { font-family: var(--font-b); color: var(--warm-dk); background: var(--cream); overflow-x: hidden; }

/* ── Tag ── */
.fq-tag {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 0.72rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
  color: var(--warm-md); background: var(--peach-2);
  padding: 7px 16px; border-radius: 50px; margin-bottom: 20px;
}
.fq-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--coral); display:inline-block; }

/* ── Hero ── */
.fq-hero {
  position: relative; background: var(--peach);
  padding: clamp(70px,10vw,120px) var(--pad) clamp(60px,8vw,100px);
  overflow: hidden;
}
.fq-hero__deco {
  position: absolute; width: 480px; height: 480px; border-radius: 50%;
  border: 1.5px solid var(--peach-2); top: -160px; right: -120px; pointer-events: none;
}
.fq-hero__deco::after {
  content:''; position:absolute; width:280px; height:280px; border-radius:50%;
  border:1.5px solid var(--peach-2); top:110px; left:60px;
}
.fq-hero__inner { position: relative; z-index: 1; max-width: var(--max); margin: 0 auto; }

.fq-hero__title {
  font-family: var(--font-d);
  font-size: clamp(2.6rem, 6vw, 4.8rem);
  font-weight: 400; line-height: 1.1;
  color: var(--warm-dk); margin-bottom: 18px;
}
.fq-hero__title em { font-style: italic; color: var(--coral); }
.fq-hero__sub {
  font-size: clamp(1rem, 2vw, 1.1rem); color: var(--warm-md);
  line-height: 1.75; max-width: 480px; font-weight: 300;
}

/* ── Body ── */
.fq-body {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: clamp(32px, 5vw, 60px);
  max-width: var(--max); margin: 0 auto;
  padding: var(--section) var(--pad);
  align-items: start;
}

/* ── FAQ items ── */
.fq-list { display: flex; flex-direction: column; gap: 10px; }

.fq-item {
  background: var(--white);
  border: 1.5px solid var(--peach-2);
  border-radius: var(--radius);
  overflow: hidden;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.fq-item:hover       { border-color: var(--peach-2); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
.fq-item--open       { border-color: var(--coral); box-shadow: 0 8px 24px rgba(212,80,26,0.1); }

.fq-item__q {
  display: flex; align-items: center; gap: 16px;
  padding: 22px 24px;
}
.fq-item__num {
  font-family: var(--font-d); font-size: 0.95rem;
  color: var(--warm-lt); flex-shrink: 0; width: 28px;
  transition: color 0.2s;
}
.fq-item--open .fq-item__num { color: var(--coral); }

.fq-item__text {
  flex: 1; font-size: 1rem; font-weight: 500;
  color: var(--warm-dk); line-height: 1.4;
  transition: color 0.2s;
}
.fq-item--open .fq-item__text { color: var(--coral); }

.fq-item__toggle {
  flex-shrink: 0; width: 36px; height: 36px;
  border-radius: 50%; border: 1.5px solid var(--peach-2);
  background: var(--peach); cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.2s, border-color 0.2s;
}
.fq-item--open .fq-item__toggle {
  background: var(--coral); border-color: var(--coral);
}
.fq-item__plus {
  font-size: 1.2rem; font-weight: 400; line-height: 1;
  color: var(--warm-md); transition: color 0.2s;
  display: flex; align-items: center; justify-content: center;
  width: 100%; height: 100%;
}
.fq-item--open .fq-item__plus { color: var(--white); }

.fq-item__a {
  max-height: 0; overflow: hidden;
  transition: max-height 0.35s ease;
  background: var(--cream);
}
.fq-item__a p {
  padding: 0 24px 22px 68px;
  font-size: 0.95rem; color: var(--warm-md);
  line-height: 1.8; font-weight: 300;
}

/* ── Sidebar ── */
.fq-sidebar { display: flex; flex-direction: column; gap: 14px; }

.fq-sidebar__card {
  background: var(--white); border: 1px solid var(--peach-2);
  border-radius: var(--radius); padding: 32px 26px;
  display: flex; flex-direction: column; gap: 12px;
}
.fq-sidebar__icon { font-size: 2rem; }
.fq-sidebar__title { font-family: var(--font-d); font-size: 1.3rem; font-weight: 400; color: var(--warm-dk); }
.fq-sidebar__body  { font-size: 0.88rem; color: var(--warm-md); line-height: 1.7; font-weight: 300; }

.fq-btn {
  display: flex; align-items: center; justify-content: center;
  gap: 8px; padding: 12px 20px; border-radius: 50px;
  font-size: 0.88rem; font-weight: 600; text-decoration: none;
  transition: all 0.2s; font-family: var(--font-b);
  background: var(--coral); color: var(--white);
  box-shadow: 0 4px 14px rgba(212,80,26,0.22);
}
.fq-btn:hover { background: var(--coral-2); transform: translateY(-2px); }
.fq-btn--outline {
  background: transparent; color: var(--coral);
  border: 1.5px solid var(--coral); box-shadow: none;
}
.fq-btn--outline:hover { background: rgba(212,80,26,0.06); transform: translateY(-2px); }

.fq-sidebar__hours {
  background: var(--peach); border: 1px solid var(--peach-2);
  border-radius: var(--radius); padding: 24px 26px;
  font-size: 0.88rem; line-height: 2; color: var(--warm-md);
}
.fq-sidebar__hours-title { font-weight: 600; color: var(--warm-dk); margin-bottom: 4px; }

/* ── Responsive ── */
@media (max-width: 800px) {
  .fq-body { grid-template-columns: 1fr; }
  .fq-sidebar { flex-direction: row; flex-wrap: wrap; }
  .fq-sidebar__card, .fq-sidebar__hours { flex: 1; min-width: 240px; }
}
@media (max-width: 500px) {
  .fq-item__a p { padding-left: 24px; }
  .fq-item__num { display: none; }
}
</style>

@endsection
