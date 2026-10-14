@extends('layouts.app')

@section('title', 'FAQs | Buying, Importing & Selling Cars in Kenya | WeSellGaris')
@section('meta_description', 'Answers to common questions about buying new and used cars, car imports, financing, trade-ins, warranty, documentation and test drives at WeSellGaris, Kenya.')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

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

  $faqSchema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $faqs),
  ];
@endphp

@push('head')
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endpush

<div class="fq-wrap">

  {{-- Hero --}}
  <section class="fq-hero">
    <div class="fq-hero__deco" aria-hidden="true"></div>
    <div class="fq-hero__inner">
      <span class="fq-tag">Help Centre</span>
      <h1 class="fq-hero__title">Frequently asked <em>questions.</em></h1>
      <p class="fq-hero__sub">Everything you need to know about buying, importing and owning a car with WeSellGaris.</p>
    </div>
  </section>

  {{-- FAQ List + Sidebar --}}
  <section class="fq-body">
    <div class="fq-list">

      @foreach($faqs as $index => $faq)
      <div class="fq-item">
        <button type="button" class="fq-item__q" id="icon-{{ $index }}" onclick="toggleFAQ({{ $index }})" aria-expanded="false" aria-controls="answer-{{ $index }}">
          <span class="fq-item__num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
          <span class="fq-item__text">{{ $faq[0] }}</span>
          <span class="fq-item__toggle" aria-hidden="true"><span class="fq-item__plus">+</span></span>
        </button>
        <div class="fq-item__a" id="answer-{{ $index }}" role="region">
          <p>{{ $faq[1] }}</p>
        </div>
      </div>
      @endforeach

    </div>

    <aside class="fq-sidebar">
      <div class="fq-card">
        <div class="fq-card__icon" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <h3 class="fq-card__title">Still have questions?</h3>
        <p class="fq-card__body">Our expert team is ready to help you find the right vehicle.</p>
        <a href="tel:+254717475336" class="fq-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          Call Us Now
        </a>
        <a href="{{ route('contact') }}" class="fq-btn fq-btn--outline">Send a Message</a>
      </div>

      <div class="fq-hours">
        <p class="fq-hours__title">Office Hours</p>
        <p><span>Mon – Fri</span><span>9AM – 6PM</span></p>
        <p><span>Saturday</span><span>10AM – 4PM</span></p>
        <p><span>Sunday</span><span>Closed</span></p>
      </div>
    </aside>

  </section>

</div>

<script>
function toggleFAQ(index) {
  const items  = document.querySelectorAll('.fq-item');
  const item   = items[index];
  const answer = document.getElementById('answer-' + index);
  const btn    = document.getElementById('icon-' + index);
  if (!item || !answer || !btn) return;
  const isOpen = item.classList.contains('fq-item--open');

  // close all
  items.forEach((el, i) => {
    el.classList.remove('fq-item--open');
    document.getElementById('answer-' + i).style.maxHeight = null;
    document.getElementById('icon-' + i).setAttribute('aria-expanded', 'false');
  });

  if (!isOpen) {
    item.classList.add('fq-item--open');
    answer.style.maxHeight = answer.scrollHeight + 'px';
    btn.setAttribute('aria-expanded', 'true');
  }
}
</script>

<style>
:root {
  --cream:#F5EBDD; --espresso:#3A2920; --orange:#D94F16; --yellow:#F5C400;
  --terracotta:#B94314; --beige:#EAD9C6; --peach:#F3D7C8;
  --font-d:'Playfair Display',Georgia,serif; --font-b:'Inter',system-ui,sans-serif;
  --pad:clamp(20px,5vw,80px);
}
.fq-wrap, .fq-wrap *, .fq-wrap *::before, .fq-wrap *::after { box-sizing: border-box; }
.fq-wrap { font-family: var(--font-b); color: var(--espresso); background: var(--cream); width:100%; overflow-x:hidden; }
:where(.fq-wrap h1, .fq-wrap h3, .fq-wrap p) { margin: 0; }

/* Tag */
.fq-tag {
  display:inline-flex; align-items:center; gap:8px; margin-bottom:26px;
  font-size:.66rem; font-weight:600; letter-spacing:.14em; text-transform:uppercase;
  background:var(--peach); padding:8px 15px; border-radius:50px;
}
.fq-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--orange); }

/* Hero */
.fq-hero { position:relative; background:var(--cream); padding:clamp(56px,8vw,96px) var(--pad) clamp(44px,6vw,72px); overflow:hidden; border-bottom:1px solid var(--beige); }
.fq-hero__deco { position:absolute; width:460px; height:460px; border-radius:50%; border:1.5px solid var(--beige); top:-170px; right:-110px; pointer-events:none; }
.fq-hero__deco::after { content:''; position:absolute; width:260px; height:260px; border-radius:50%; border:1.5px solid var(--beige); top:110px; left:60px; }
.fq-hero__inner { position:relative; z-index:1; max-width:1100px; margin:0 auto; }
.fq-hero__title { font-family:var(--font-d); font-size:clamp(2.3rem,4.6vw,3.7rem); font-weight:600; line-height:1.1; margin-bottom:18px; }
.fq-hero__title em { font-style:italic; color:var(--orange); }
.fq-hero__sub { font-size:clamp(.95rem,1.5vw,1.1rem); opacity:.78; max-width:520px; line-height:1.7; }

/* Body */
.fq-body { display:grid; grid-template-columns:1fr 310px; gap:clamp(28px,5vw,56px); max-width:1100px; margin:0 auto; padding:clamp(44px,6vw,80px) var(--pad); align-items:start; }

/* FAQ items */
.fq-list { display:flex; flex-direction:column; gap:12px; }
.fq-item { background:#fff; border:1px solid var(--beige); border-radius:16px; overflow:hidden; box-shadow:0 2px 8px rgba(58,41,32,.06); transition:border-color .2s, box-shadow .2s; }
.fq-item:hover { box-shadow:0 8px 22px rgba(58,41,32,.09); }
.fq-item--open { border-color:var(--orange); box-shadow:0 8px 24px rgba(217,79,22,.12); }

.fq-item__q {
  width:100%; display:flex; align-items:center; gap:16px; padding:20px 22px;
  background:none; border:none; cursor:pointer; text-align:left; font:inherit; color:inherit;
}
.fq-item__q:focus-visible { outline:3px solid var(--yellow); outline-offset:-3px; border-radius:16px; }
.fq-item__num { font-family:var(--font-d); font-size:1rem; font-weight:600; color:var(--orange); opacity:.55; flex-shrink:0; width:28px; transition:opacity .2s; }
.fq-item--open .fq-item__num { opacity:1; }
.fq-item__text { flex:1; font-size:.98rem; font-weight:600; line-height:1.4; transition:color .2s; }
.fq-item--open .fq-item__text { color:var(--orange); }

.fq-item__toggle { flex-shrink:0; width:34px; height:34px; border-radius:50%; background:var(--cream); border:1px solid var(--beige); display:flex; align-items:center; justify-content:center; transition:background .2s, border-color .2s; }
.fq-item__plus { font-size:1.2rem; line-height:1; color:var(--espresso); transition:transform .25s, color .2s; }
.fq-item--open .fq-item__toggle { background:var(--orange); border-color:var(--orange); }
.fq-item--open .fq-item__plus { color:#fff; transform:rotate(45deg); }

.fq-item__a { max-height:0; overflow:hidden; transition:max-height .35s ease; }
.fq-item__a p { padding:0 24px 22px 66px; font-size:.94rem; line-height:1.8; opacity:.8; }

/* Sidebar */
.fq-sidebar { display:flex; flex-direction:column; gap:14px; position:sticky; top:96px; }
.fq-card { background:#fff; border:1px solid var(--beige); border-radius:16px; padding:28px 24px; display:flex; flex-direction:column; gap:12px; box-shadow:0 2px 8px rgba(58,41,32,.06); }
.fq-card__icon { width:46px; height:46px; border-radius:12px; background:var(--peach); color:var(--orange); display:flex; align-items:center; justify-content:center; }
.fq-card__title { font-family:var(--font-d); font-size:1.35rem; font-weight:600; }
.fq-card__body { font-size:.88rem; line-height:1.7; opacity:.75; }

.fq-btn {
  display:flex; align-items:center; justify-content:center; gap:8px; min-height:46px; padding:12px 20px;
  border-radius:50px; background:var(--orange); color:#fff; font:600 .88rem var(--font-b); text-decoration:none;
  box-shadow:0 6px 20px rgba(217,79,22,.3); transition:.2s;
}
.fq-btn:hover { background:var(--terracotta); color:#fff; transform:translateY(-2px); }
.fq-btn--outline { background:transparent; color:var(--orange); border:1.5px solid var(--orange); box-shadow:none; }
.fq-btn--outline:hover { background:var(--peach); color:var(--terracotta); }
.fq-btn:focus-visible { outline:3px solid var(--yellow); outline-offset:2px; }

.fq-hours { background:var(--espresso); color:var(--cream); border-radius:16px; padding:24px; }
.fq-hours__title { font-family:var(--font-d); font-size:1.1rem; font-weight:600; margin-bottom:10px; color:var(--yellow); }
.fq-hours p { display:flex; justify-content:space-between; gap:12px; font-size:.86rem; padding:8px 0; border-top:1px solid rgba(245,235,221,.14); }
.fq-hours p.fq-hours__title { border-top:none; padding:0 0 10px; display:block; }
.fq-hours p span:last-child { opacity:.8; }

/* Responsive */
@media (max-width:860px) {
  .fq-body { grid-template-columns:1fr; }
  .fq-sidebar { position:static; flex-direction:row; flex-wrap:wrap; }
  .fq-card, .fq-hours { flex:1 1 260px; }
}
@media (max-width:500px) {
  .fq-item__num { display:none; }
  .fq-item__a p { padding-left:22px; }
  .fq-item__q { padding:18px; }
}
@media (prefers-reduced-motion:reduce) { .fq-wrap * { transition:none !important; } }
</style>

@endsection
