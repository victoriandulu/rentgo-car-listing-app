@extends('layouts.app')

@section('title', 'Contact Us | WeSellGaris | Cars for Sale & Imports in Kenya')
@section('meta_description', 'Get in touch with WeSellGaris in Nairobi. Call, email or send us a message about buying, importing or selling a car in Kenya.')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<div class="ct-wrap">

  {{-- Hero --}}
  <section class="ct-hero">
    <div class="ct-hero__deco" aria-hidden="true"></div>
    <div class="ct-hero__inner">
      <span class="ct-tag">We'd love to hear from you</span>
      <h1 class="ct-hero__title">Get in <em>touch.</em></h1>
      <p class="ct-hero__sub">Questions about buying, importing or selling a car? Reach out any time and we'll help you find the right way forward.</p>
    </div>
  </section>

  {{-- Main Content --}}
  <div class="ct-body">

    {{-- Info Cards --}}
    <aside class="ct-info">
      <div class="ct-info-card">
        <div class="ct-info-card__icon" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <h3 class="ct-info-card__title">Call Us</h3>
          <a class="ct-info-card__val" href="tel:+254705558711">+254-705-558-711</a>
          <p class="ct-info-card__sub">Mon–Fri: 9AM – 6PM</p>
        </div>
      </div>
      <div class="ct-info-card">
        <div class="ct-info-card__icon" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
        </div>
        <div>
          <h3 class="ct-info-card__title">Email Us</h3>
          <a class="ct-info-card__val" href="mailto:wesellgaris.ke@gmail.com">wesellgaris.ke@gmail.com</a>
          <p class="ct-info-card__sub">We reply within 24 hours</p>
        </div>
      </div>
      <div class="ct-info-card">
        <div class="ct-info-card__icon" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <h3 class="ct-info-card__title">Visit Us</h3>
          <p class="ct-info-card__val">Kenya Railways Station</p>
          <p class="ct-info-card__sub">Nairobi, Kenya</p>
        </div>
      </div>
    </aside>

    {{-- Form --}}
    <div class="ct-form-wrap" id="formWrap">
      <form class="ct-form" id="contactForm" onsubmit="sendToWhatsApp(event)">
        @csrf
        <h2 class="ct-form__title">Send us a message</h2>
        <p class="ct-form__sub">Fill in the form and we'll get back to you shortly.</p>

        <div class="ct-field">
          <label class="ct-label" for="name">Full Name <span class="ct-req">*</span></label>
          <input class="ct-input" type="text" name="name" id="name" placeholder="Enter your full name" required>
        </div>

        <div class="ct-row">
          <div class="ct-field">
            <label class="ct-label" for="email">Email Address <span class="ct-req">*</span></label>
            <input class="ct-input" type="email" name="email" id="email" placeholder="your@email.com" required>
          </div>
          <div class="ct-field">
            <label class="ct-label" for="phone">Phone <span class="ct-opt">(optional)</span></label>
            <input class="ct-input" type="tel" name="phone" id="phone" placeholder="+254 XXX XXX XXX">
          </div>
        </div>

        <div class="ct-field">
          <label class="ct-label" for="subject">Subject</label>
          <select class="ct-input ct-select" name="subject" id="subject">
            <option value="General Inquiry">General Inquiry</option>
            <option value="Buying a Car">Buying a Car</option>
            <option value="Selling My Car">Selling My Car</option>
            <option value="Car Imports">Car Imports</option>
            <option value="Financing & Trade-ins">Financing &amp; Trade-ins</option>
            <option value="Technical Support">Technical Support</option>
            <option value="Feedback">Feedback</option>
          </select>
        </div>

        <div class="ct-field">
          <label class="ct-label" for="message">Message <span class="ct-req">*</span></label>
          <textarea class="ct-input ct-textarea" name="message" id="message" rows="5" placeholder="Tell us how we can help you…" required></textarea>
        </div>

        <button type="submit" class="ct-btn ct-btn--primary">Send Message →</button>
      </form>
    </div>

  </div>

  {{-- Quick answers --}}
  <section class="ct-faq">
    <div class="ct-faq__head">
      <span class="ct-tag">Quick Answers</span>
      <h2 class="ct-section-title">Common <em>questions.</em></h2>
    </div>
    <div class="ct-faq__grid">
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">What documents do I need to buy?</h3>
        <p class="ct-faq-card__a">A valid ID (passport or national ID), proof of address, and a tax compliance certificate. For financing, your bank may need additional documents.</p>
      </div>
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">How long does an import take?</h3>
        <p class="ct-faq-card__a">Usually 4–6 weeks from order confirmation to delivery. Custom or specialty vehicles may take longer, and we keep you updated throughout.</p>
      </div>
      <div class="ct-faq-card">
        <h3 class="ct-faq-card__q">Can I test drive a car?</h3>
        <p class="ct-faq-card__a">Yes. Call us or send a message to arrange a test drive of any vehicle in our inventory.</p>
      </div>
    </div>
    <div class="ct-faq__more">
      <a href="{{ route('faqs') }}" class="ct-btn ct-btn--outline">See all FAQs →</a>
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
.ct-wrap, .ct-wrap *, .ct-wrap *::before, .ct-wrap *::after { box-sizing: border-box; }
.ct-wrap { font-family: var(--font-b); color: var(--espresso); background: var(--cream); width:100%; overflow-x:hidden; }
:where(.ct-wrap h1, .ct-wrap h2, .ct-wrap h3, .ct-wrap p) { margin: 0; }

/* Shared */
.ct-tag {
  display:inline-flex; align-items:center; gap:8px; margin-bottom:26px;
  font-size:.66rem; font-weight:600; letter-spacing:.14em; text-transform:uppercase;
  background:var(--peach); padding:8px 15px; border-radius:50px;
}
.ct-tag::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--orange); }
.ct-section-title { font-family:var(--font-d); font-size:clamp(1.9rem,3.6vw,2.8rem); font-weight:600; line-height:1.15; }
.ct-section-title em { font-style:italic; color:var(--orange); }

/* Hero */
.ct-hero { position:relative; background:var(--cream); padding:clamp(56px,8vw,96px) var(--pad) clamp(44px,6vw,72px); overflow:hidden; border-bottom:1px solid var(--beige); }
.ct-hero__deco { position:absolute; width:460px; height:460px; border-radius:50%; border:1.5px solid var(--beige); top:-170px; right:-110px; pointer-events:none; }
.ct-hero__deco::after { content:''; position:absolute; width:260px; height:260px; border-radius:50%; border:1.5px solid var(--beige); top:110px; left:60px; }
.ct-hero__inner { position:relative; z-index:1; max-width:1100px; margin:0 auto; }
.ct-hero__title { font-family:var(--font-d); font-size:clamp(2.5rem,5.4vw,4.1rem); font-weight:600; line-height:1.08; margin-bottom:18px; }
.ct-hero__title em { font-style:italic; color:var(--orange); }
.ct-hero__sub { font-size:clamp(.95rem,1.5vw,1.1rem); opacity:.78; max-width:520px; line-height:1.7; }

/* Body */
.ct-body { display:grid; grid-template-columns:320px 1fr; gap:clamp(28px,5vw,56px); max-width:1100px; margin:0 auto; padding:clamp(44px,6vw,80px) var(--pad); align-items:start; }

/* Info cards */
.ct-info { display:flex; flex-direction:column; gap:14px; }
.ct-info-card { background:#fff; border:1px solid var(--beige); border-radius:16px; padding:22px; display:flex; align-items:flex-start; gap:16px; box-shadow:0 2px 8px rgba(58,41,32,.06); transition:box-shadow .2s, transform .2s; }
.ct-info-card:hover { box-shadow:0 8px 22px rgba(58,41,32,.1); transform:translateY(-3px); }
.ct-info-card__icon { flex-shrink:0; width:46px; height:46px; border-radius:12px; background:var(--peach); color:var(--orange); display:flex; align-items:center; justify-content:center; }
.ct-info-card__title { font-family:var(--font-d); font-size:1.1rem; font-weight:600; margin-bottom:4px; }
.ct-info-card__val { display:block; font-size:.93rem; font-weight:600; color:var(--espresso); text-decoration:none; margin-bottom:3px; word-break:break-word; }
a.ct-info-card__val:hover { color:var(--orange); }
.ct-info-card__sub { font-size:.8rem; opacity:.65; }

/* Form */
.ct-form-wrap { background:#fff; border:1px solid var(--beige); border-radius:20px; padding:clamp(26px,4.5vw,46px); box-shadow:0 2px 8px rgba(58,41,32,.06); }
.ct-form__title { font-family:var(--font-d); font-size:1.8rem; font-weight:600; margin-bottom:6px; }
.ct-form__sub { font-size:.92rem; opacity:.72; margin-bottom:28px; }

.ct-field { margin-bottom:20px; }
.ct-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:20px; }
.ct-row .ct-field { margin-bottom:0; }
.ct-label { display:block; font-size:.82rem; font-weight:600; margin-bottom:8px; }
.ct-req { color:var(--orange); }
.ct-opt { opacity:.6; font-weight:400; }

.ct-input {
  width:100%; min-height:46px; padding:12px 14px; border:1px solid var(--beige); border-radius:10px;
  font:500 .92rem var(--font-b); color:var(--espresso); background:var(--cream);
  transition:border-color .2s, box-shadow .2s, background .2s; appearance:none; -webkit-appearance:none;
}
.ct-input:focus { outline:none; border-color:var(--orange); background:#fff; box-shadow:0 0 0 3px rgba(217,79,22,.14); }
.ct-input::placeholder { color:rgba(58,41,32,.45); }
.ct-select {
  cursor:pointer; padding-right:38px;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%233A2920' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
  background-repeat:no-repeat; background-position:right 12px center;
}
.ct-textarea { resize:vertical; min-height:130px; }

/* Buttons */
.ct-btn {
  display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:48px;
  padding:14px 30px; border-radius:50px; font:600 .9rem var(--font-b); cursor:pointer;
  text-decoration:none; border:none; transition:.2s; width:100%;
}
.ct-btn--primary { background:var(--orange); color:#fff; box-shadow:0 6px 20px rgba(217,79,22,.3); }
.ct-btn--primary:hover { background:var(--terracotta); transform:translateY(-2px); }
.ct-btn--outline { background:transparent; color:var(--orange); border:1.5px solid var(--orange); width:auto; }
.ct-btn--outline:hover { background:var(--peach); color:var(--terracotta); }
.ct-btn:focus-visible, .ct-input:focus-visible { outline:3px solid var(--yellow); outline-offset:2px; }

/* Success (shown by the WhatsApp script) */
.ct-success { text-align:center; padding:44px 20px; }
.ct-success__icon { width:72px; height:72px; border-radius:50%; background:var(--orange); color:#fff; font-size:2rem; font-weight:700; display:flex; align-items:center; justify-content:center; margin:0 auto 22px; box-shadow:0 8px 24px rgba(217,79,22,.3); }
.ct-success__title { font-family:var(--font-d); font-size:1.9rem; font-weight:600; margin-bottom:10px; }
.ct-success__body { font-size:1rem; opacity:.75; }

/* Quick answers */
.ct-faq { background:var(--espresso); color:var(--cream); padding:clamp(48px,7vw,88px) var(--pad); }
.ct-faq .ct-tag { background:rgba(245,235,221,.12); color:var(--cream); }
.ct-faq .ct-tag::before { background:var(--yellow); }
.ct-faq .ct-section-title em { color:var(--yellow); }
.ct-faq__head { max-width:1100px; margin:0 auto 36px; }
.ct-faq__grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; max-width:1100px; margin:0 auto; }
.ct-faq-card { background:rgba(245,235,221,.06); border:1px solid rgba(245,235,221,.14); border-radius:16px; padding:28px 24px; transition:background .2s, transform .2s; }
.ct-faq-card:hover { background:rgba(245,235,221,.1); transform:translateY(-4px); }
.ct-faq-card__q { font-family:var(--font-d); font-size:1.15rem; font-weight:600; margin-bottom:10px; }
.ct-faq-card__a { font-size:.9rem; line-height:1.75; opacity:.78; }
.ct-faq__more { max-width:1100px; margin:30px auto 0; }
.ct-faq .ct-btn--outline { color:var(--yellow); border-color:var(--yellow); }
.ct-faq .ct-btn--outline:hover { background:var(--yellow); color:var(--espresso); }

/* Responsive */
@media (max-width:860px) {
  .ct-body { grid-template-columns:1fr; }
  .ct-info { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); }
  .ct-faq__grid { grid-template-columns:1fr; }
}
@media (max-width:540px) {
  .ct-row { grid-template-columns:1fr; }
  .ct-faq .ct-btn--outline { width:100%; }
}
@media (prefers-reduced-motion:reduce) { .ct-wrap * { transition:none !important; } }
</style>

{{-- WhatsApp Integration Script --}}
<script>
function sendToWhatsApp(event) {
    event.preventDefault();

    // Get form values
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value.trim();

    // Validate required fields
    if (!name) {
        alert('⚠️ Please enter your full name');
        document.getElementById('name').focus();
        return false;
    }

    if (!email) {
        alert('⚠️ Please enter your email address');
        document.getElementById('email').focus();
        return false;
    }

    if (!message) {
        alert('⚠️ Please enter your message');
        document.getElementById('message').focus();
        return false;
    }

    // Build WhatsApp message
    let whatsappMsg = '';
    whatsappMsg += '📧 *NEW CONTACT FORM MESSAGE*%0A%0A';
    whatsappMsg += '👤 *Name:* ' + encodeURIComponent(name) + '%0A';
    whatsappMsg += '📧 *Email:* ' + encodeURIComponent(email) + '%0A';
    whatsappMsg += '📱 *Phone:* ' + (phone ? encodeURIComponent(phone) : 'Not provided') + '%0A';
    whatsappMsg += '📋 *Subject:* ' + encodeURIComponent(subject) + '%0A%0A';
    whatsappMsg += '📝 *Message:*%0A' + encodeURIComponent(message) + '%0A%0A';
    whatsappMsg += '🕐 *Sent:* ' + encodeURIComponent(new Date().toLocaleString('en-KE', {
        timeZone: 'Africa/Nairobi'
    }));

    // WhatsApp number (Kenya format - remove leading zero)
    const phoneNumber = '254705558711';

    // Open WhatsApp
    const whatsappURL = 'https://wa.me/' + phoneNumber + '?text=' + whatsappMsg;
    window.open(whatsappURL, '_blank');

    // Show success message
    const formWrap = document.getElementById('formWrap');
    formWrap.innerHTML = `
        <div class="ct-success">
            <div class="ct-success__icon">✓</div>
            <h2 class="ct-success__title">Message Ready!</h2>
            <p class="ct-success__body">Your message has been prepared. Click "Send" on WhatsApp to complete.</p>
            <br>
            <a href="{{ url()->current() }}" class="ct-btn ct-btn--outline">Send Another Message</a>
        </div>
    `;
}
</script>

@endsection
