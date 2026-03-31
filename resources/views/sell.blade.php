@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --rose:       #F45B38;
    --rose-soft:  #FF8066;
    --rose-pale:  #FFF0EC;
    --amber:      #F9A825;
    --warm-white: #FFFCF9;
    --parchment:  #FEF3EA;
    --peach-mid:  #FDEADB;
    --peach-deep: #FBD9C6;
    --text-head:  #2D1A0E;
    --text-body:  #7A5544;
    --text-muted: #B89080;
    --border:     rgba(244,91,56,0.14);
    --shadow-sm:  0 2px 10px rgba(244,91,56,0.07);
    --shadow-md:  0 8px 28px rgba(244,91,56,0.13);
    --ease:       cubic-bezier(0.22,1,0.36,1);
    --r:          14px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--warm-white);
    color: var(--text-head);
}

/* ─── TWO-COLUMN LAYOUT ─── */
.sc-wrap {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 100vh;
    align-items: stretch;
}

/* ══════════════════════════════════════
   LEFT PANEL — warm parchment
══════════════════════════════════════ */
.sc-left {
    background: linear-gradient(150deg, var(--parchment) 0%, var(--peach-mid) 55%, var(--peach-deep) 100%);
    padding: 52px 48px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    position: relative;
    overflow: hidden;
}

/* decorative rings */
.sc-left::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border: 1.5px solid rgba(244,91,56,0.09);
    border-radius: 50%;
    top: -130px; right: -120px;
    pointer-events: none;
}
.sc-left::after {
    content: '';
    position: absolute;
    width: 240px; height: 240px;
    border: 1.5px solid rgba(249,168,37,0.14);
    border-radius: 50%;
    top: -55px; right: -55px;
    pointer-events: none;
}
.sc-blob-bl {
    position: absolute;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(244,91,56,0.08) 0%, transparent 70%);
    bottom: -90px; left: -70px;
    border-radius: 50%;
    pointer-events: none;
}

/* Brand */
.sc-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative; z-index: 2;
}
.sc-brand-mark {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, var(--rose), var(--amber));
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px;
    box-shadow: 0 4px 14px rgba(244,91,56,0.3);
    flex-shrink: 0;
}
.sc-brand-name {
    font-family: 'DM Serif Display', serif;
    font-size: 22px;
    color: var(--text-head);
}

/* Hero copy */
.sc-hero { position: relative; z-index: 2; }

.sc-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: white;
    border: 1px solid var(--border);
    color: var(--rose);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 6px 13px;
    border-radius: 100px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}
.sc-pill::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--rose);
    border-radius: 50%;
    animation: blink 2s ease-in-out infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.25} }

.sc-hero h1 {
    font-family: 'DM Serif Display', serif;
    font-size: clamp(34px, 3.2vw, 48px);
    color: var(--text-head);
    line-height: 1.13;
    letter-spacing: -0.8px;
    margin-bottom: 14px;
}
.sc-hero h1 .accent { color: var(--rose); font-style: italic; }

.sc-hero p {
    font-size: 15px;
    color: var(--text-body);
    line-height: 1.75;
    max-width: 360px;
}

/* Stats */
.sc-stats {
    display: flex;
    gap: 12px;
    position: relative; z-index: 2;
}
.sc-stat {
    flex: 1;
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px 12px;
    box-shadow: var(--shadow-sm);
    transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
    text-align: left;
}
.sc-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
.sc-stat-num {
    display: block;
    font-family: 'DM Serif Display', serif;
    font-size: 26px;
    color: var(--rose);
    margin-bottom: 3px;
}
.sc-stat-lbl {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Benefits */
.sc-benefits {
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: relative; z-index: 2;
}
.sc-benefit {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: var(--text-body);
    font-weight: 500;
}
.sc-check {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: white;
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: var(--shadow-sm);
}
.sc-check i { font-size: 9px; color: var(--rose); }

/* Testimonial */
.sc-testi {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(244,91,56,0.08);
    position: relative;
    overflow: hidden;
    z-index: 2;
}
.sc-testi::before {
    content: '"';
    position: absolute;
    top: -6px; right: 18px;
    font-family: 'DM Serif Display', serif;
    font-size: 100px;
    color: var(--rose-pale);
    line-height: 1;
    pointer-events: none;
}
.sc-testi-text {
    font-size: 14px;
    color: var(--text-body);
    line-height: 1.7;
    margin-bottom: 16px;
    font-style: italic;
    position: relative; z-index: 1;
}
.sc-testi-foot { display: flex; align-items: center; gap: 11px; }
.sc-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--amber));
    display: flex; align-items: center; justify-content: center;
    font-family: 'DM Serif Display', serif;
    font-size: 13px; color: white; flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(244,91,56,0.25);
}
.sc-author-name { font-size: 13px; font-weight: 700; color: var(--text-head); display: block; margin-bottom: 2px; }
.sc-stars { color: var(--amber); font-size: 11px; letter-spacing: 1px; }

/* ══════════════════════════════════════
   RIGHT PANEL — form
══════════════════════════════════════ */
.sc-right {
    background: var(--warm-white);
    padding: 52px 52px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

/* soft glow top-right */
.sc-right::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 320px; height: 320px;
    background: radial-gradient(circle, rgba(249,168,37,0.1) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
/* soft glow bottom-left */
.sc-right::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(244,91,56,0.06) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

/* subtle vertical divider */
.sc-divider-line {
    position: absolute;
    left: 0; top: 6%; bottom: 6%;
    width: 1px;
    background: linear-gradient(to bottom, transparent, var(--border) 25%, var(--border) 75%, transparent);
    pointer-events: none;
}

.sc-form-card {
    width: 100%;
    max-width: 430px;
    margin: 0 auto;
    position: relative; z-index: 2;
}

/* heading */
.sc-fhead { margin-bottom: 26px; }
.sc-fhead h2 {
    font-family: 'DM Serif Display', serif;
    font-size: 32px;
    color: var(--text-head);
    letter-spacing: -0.5px;
    margin-bottom: 6px;
    line-height: 1.15;
}
.sc-fhead p { font-size: 14px; color: var(--text-muted); line-height: 1.55; }

/* tabs */
.sc-tabs {
    display: flex;
    background: var(--rose-pale);
    border-radius: 14px;
    padding: 4px;
    margin-bottom: 20px;
    border: 1px solid var(--border);
}
.sc-tab {
    flex: 1;
    background: none; border: none;
    padding: 10px 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px; font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    border-radius: 11px;
    transition: all 0.22s var(--ease);
}
.sc-tab.active {
    background: white;
    color: var(--rose);
    box-shadow: 0 2px 10px rgba(244,91,56,0.12);
}

/* google btn */
.btn-google {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px 18px;
    background: white;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px; font-weight: 600;
    color: var(--text-head);
    text-decoration: none;
    transition: all 0.22s var(--ease);
    margin-bottom: 18px;
    box-shadow: var(--shadow-sm);
}
.btn-google:hover {
    border-color: var(--rose-soft);
    box-shadow: var(--shadow-md);
    transform: translateY(-1px);
    text-decoration: none;
    color: var(--text-head);
}
.btn-google svg { width: 18px; height: 18px; flex-shrink: 0; }

/* or divider */
.sc-or {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}
.sc-or::before, .sc-or::after {
    content: '';
    flex: 1; height: 1px;
    background: linear-gradient(90deg, transparent, var(--border), transparent);
}
.sc-or span {
    font-size: 11px; font-weight: 700;
    color: var(--text-muted);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    white-space: nowrap;
}

/* forms */
.sc-form { display: none; }
.sc-form.active { display: block; }

.sc-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.sc-field { margin-bottom: 14px; }

.sc-field label {
    display: block;
    font-size: 12.5px; font-weight: 700;
    color: var(--text-head);
    margin-bottom: 6px;
}

.sc-iw { position: relative; }

.sc-iw input {
    width: 100%;
    padding: 11px 15px;
    background: white;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--text-head);
    outline: none;
    transition: all 0.2s var(--ease);
    box-shadow: var(--shadow-sm);
}
.sc-iw input::placeholder { color: var(--text-muted); }
.sc-iw input:focus {
    border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(244,91,56,0.1);
}
.sc-iw input.error { border-color: #FF6B6B; background: #fff8f8; }
.sc-iw input[type="password"] { padding-right: 44px; }

.sc-eye {
    position: absolute;
    right: 13px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer; color: var(--text-muted);
    padding: 4px; line-height: 1;
    transition: color 0.2s;
}
.sc-eye:hover { color: var(--rose); }

.sc-ferr {
    font-size: 11.5px; color: #FF6B6B;
    margin-top: 4px; font-weight: 500;
}

/* submit */
.sc-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 22px;
    background: linear-gradient(135deg, var(--rose) 0%, #F06525 45%, var(--amber) 100%);
    background-size: 200% auto;
    color: white; border: none;
    border-radius: var(--r);
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px; font-weight: 700;
    cursor: pointer;
    transition: all 0.32s var(--ease);
    box-shadow: 0 7px 22px rgba(244,91,56,0.35);
    margin-top: 6px;
    letter-spacing: 0.1px;
}
.sc-submit:hover {
    background-position: right center;
    box-shadow: 0 12px 34px rgba(244,91,56,0.42);
    transform: translateY(-2px);
}
.sc-submit i { font-size: 12px; }

/* footer link */
.sc-foot {
    text-align: center;
    margin-top: 16px;
    font-size: 13.5px;
    color: var(--text-muted);
}
.sc-foot a {
    color: var(--rose);
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s;
}
.sc-foot a:hover { color: var(--rose-soft); }

/* alerts */
.sc-alert {
    padding: 12px 15px;
    border-radius: 12px;
    font-size: 13px; font-weight: 500;
    margin-bottom: 16px;
    display: none; line-height: 1.5;
}
.sc-alert.show { display: block; }
.sc-alert-ok  { background: #F0FDF4; color: #16A34A; border: 1.5px solid #BBF7D0; }
.sc-alert-err { background: #FFF7F5; color: var(--rose); border: 1.5px solid rgba(244,91,56,0.22); }

/* ══════════════════════════════════════
   RESPONSIVE — MOBILE FIRST REORDER
   On small screens: form comes FIRST,
   marketing panel comes SECOND (below)
══════════════════════════════════════ */
@media (max-width: 900px) {
    .sc-wrap {
        grid-template-columns: 1fr;
        min-height: unset;       /* kill the 100vh forcing stretch */
        align-items: unset;
        height: auto;
    }
    .sc-right {
        order: 1;
        padding: 52px 28px 40px;
        justify-content: flex-start;
        min-height: unset;
        height: auto;
    }
    .sc-left {
        order: 2;
        padding: 40px 28px;
        gap: 26px;
    }
    .sc-divider-line { display: none; }
}

@media (max-width: 520px) {
    .sc-right { padding: 52px 18px 36px; justify-content: flex-start; min-height: unset; }
    .sc-left  { padding: 30px 18px; gap: 22px; }
    .sc-row   { grid-template-columns: 1fr; }
    .sc-stats { flex-wrap: wrap; }
}
</style>

<div class="sc-wrap">

    {{-- ════ LEFT — Marketing Panel ════ --}}
    <div class="sc-left">
        <div class="sc-blob-bl"></div>

        {{-- Brand --}}
        <div class="sc-brand">
            <div class="sc-brand-mark"></div>
            <span class="sc-brand-name"></span>
        </div>

        {{-- Hero --}}
        <div class="sc-hero">
            <div class="sc-pill">Trusted by 50,000+ sellers</div>
            <h1>The smarter way<br>to sell your <span class="accent">car.</span></h1>
            <p>List for free, reach verified buyers, and close your sale in days — not months. No middlemen, no surprises.</p>
        </div>

        {{-- Stats --}}
        <div class="sc-stats">
            <div class="sc-stat">
                <span class="sc-stat-num">50K+</span>
                <span class="sc-stat-lbl">Cars Sold</span>
            </div>
            <div class="sc-stat">
                <span class="sc-stat-num">4.8★</span>
                <span class="sc-stat-lbl">Avg Rating</span>
            </div>
            <div class="sc-stat">
                <span class="sc-stat-num">7 Days</span>
                <span class="sc-stat-lbl">Avg Sale</span>
            </div>
        </div>

        {{-- Benefits --}}
        <div class="sc-benefits">
            <div class="sc-benefit">
                <div class="sc-check"><i class="fas fa-check"></i></div>
                Free listings — zero hidden fees
            </div>
            <div class="sc-benefit">
                <div class="sc-check"><i class="fas fa-check"></i></div>
                Up to 15% more than dealer trade-in
            </div>
            <div class="sc-benefit">
                <div class="sc-check"><i class="fas fa-check"></i></div>
                Verified buyers &amp; secure payments
            </div>
            <div class="sc-benefit">
                <div class="sc-check"><i class="fas fa-check"></i></div>
                Smart market pricing tools included
            </div>
        </div>

        {{-- Testimonial --}}
        <div class="sc-testi">
            <p class="sc-testi-text">"Sold my BMW in 3 days and got 3.5m more than the dealership offered. Absolutely incredible experience."</p>
            <div class="sc-testi-foot">
                <div class="sc-avatar">MT</div>
                <div>
                    <span class="sc-author-name">Michael T.</span>
                    <span class="sc-stars">★★★★★</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ════ RIGHT — Form Panel ════ --}}
    <div class="sc-right">
        <div class="sc-divider-line"></div>

        <div class="sc-form-card">

            <div class="sc-fhead">
                <h2 id="formTitle">Create your account</h2>
                <p id="formSubtitle">Start listing your car in minutes. It's completely free.</p>
            </div>

            @if(session('success'))
                <div class="sc-alert sc-alert-ok show">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="sc-alert sc-alert-err show">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            {{-- Tabs --}}
            <div class="sc-tabs">
                <button class="sc-tab {{ !session('login_tab') ? 'active' : '' }}" onclick="switchTab('signup')">Create Account</button>
                <button class="sc-tab {{ session('login_tab') ? 'active' : '' }}"  onclick="switchTab('login')">Log In</button>
            </div>

            {{-- Google --}}
            <a href="{{ route('auth.google') }}" class="btn-google">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span id="googleText">Continue with Google</span>
            </a>

            {{-- ── SIGN UP FORM ── --}}
            <form class="sc-form {{ !session('login_tab') ? 'active' : '' }}"
                  id="signupForm" method="POST"
                  action="{{ route('auth.register') }}{{ request('redirect') ? '?redirect='.urlencode(request('redirect')) : '' }}">
                @csrf

                <div class="sc-row">
                    <div class="sc-field">
                        <label for="firstName">First Name</label>
                        <div class="sc-iw">
                            <input type="text" id="firstName" name="firstName"
                                   value="{{ old('firstName') }}" required placeholder="John"
                                   class="{{ $errors->has('firstName') ? 'error' : '' }}">
                        </div>
                        @error('firstName')<div class="sc-ferr">{{ $message }}</div>@enderror
                    </div>
                    <div class="sc-field">
                        <label for="lastName">Last Name</label>
                        <div class="sc-iw">
                            <input type="text" id="lastName" name="lastName"
                                   value="{{ old('lastName') }}" required placeholder="Doe"
                                   class="{{ $errors->has('lastName') ? 'error' : '' }}">
                        </div>
                        @error('lastName')<div class="sc-ferr">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="sc-field">
                    <label for="email">Email Address</label>
                    <div class="sc-iw">
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" required placeholder="john@example.com"
                               class="{{ $errors->has('email') ? 'error' : '' }}">
                    </div>
                    @error('email')<div class="sc-ferr">{{ $message }}</div>@enderror
                </div>

                <div class="sc-field">
                    <label for="password">Password</label>
                    <div class="sc-iw">
                        <input type="password" id="password" name="password"
                               required placeholder="Min. 8 characters"
                               class="{{ $errors->has('password') ? 'error' : '' }}">
                        <button type="button" class="sc-eye" onclick="togglePw('password',this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')<div class="sc-ferr">{{ $message }}</div>@enderror
                </div>

                <div class="sc-field">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="sc-iw">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               required placeholder="Repeat your password">
                        <button type="button" class="sc-eye" onclick="togglePw('password_confirmation',this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="sc-submit">
                    Get Started — It's Free <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            {{-- ── LOGIN FORM ── --}}
            <form class="sc-form {{ session('login_tab') ? 'active' : '' }}"
                  id="loginForm" method="POST"
                  action="{{ route('auth.login') }}{{ request('redirect') ? '?redirect='.urlencode(request('redirect')) : '' }}">
                @csrf

                <div class="sc-field">
                    <label for="login_email">Email Address</label>
                    <div class="sc-iw">
                        <input type="email" id="login_email" name="email"
                               value="{{ old('email') }}" required placeholder="john@example.com"
                               class="{{ $errors->has('email') ? 'error' : '' }}">
                    </div>
                    @error('email')<div class="sc-ferr">{{ $message }}</div>@enderror
                </div>

                <div class="sc-field">
                    <label for="login_password">Password</label>
                    <div class="sc-iw">
                        <input type="password" id="login_password" name="password"
                               required placeholder="Your password"
                               class="{{ $errors->has('password') ? 'error' : '' }}">
                        <button type="button" class="sc-eye" onclick="togglePw('login_password',this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')<div class="sc-ferr">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="sc-submit">
                    Log In &amp; Start Selling <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="sc-foot" id="switchText">
                @if(!session('login_tab'))
                    Already have an account?
                    <a href="#" onclick="switchTab('login'); return false;">Log In</a>
                @else
                    Don't have an account?
                    <a href="#" onclick="switchTab('signup'); return false;">Sign Up Free</a>
                @endif
            </div>

        </div>
    </div>

</div>

<script>
function switchTab(tab) {
    const s = tab === 'signup';
    document.querySelectorAll('.sc-tab').forEach((t,i) => t.classList.toggle('active', s ? i===0 : i===1));
    document.querySelectorAll('.sc-form').forEach(f => f.classList.remove('active'));
    document.getElementById(s ? 'signupForm' : 'loginForm').classList.add('active');
    document.getElementById('formTitle').textContent    = s ? 'Create your account'   : 'Welcome back';
    document.getElementById('formSubtitle').textContent = s ? "Start listing your car in minutes. It's completely free." : 'Log in to manage your listings and messages.';
    document.getElementById('googleText').textContent   = s ? 'Continue with Google'  : 'Log in with Google';
    document.getElementById('switchText').innerHTML     = s
        ? 'Already have an account? <a href="#" onclick="switchTab(\'login\'); return false;">Log In</a>'
        : "Don't have an account? <a href=\"#\" onclick=\"switchTab('signup'); return false;\">Sign Up Free</a>";
}
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const ico = btn.querySelector('i');
    const vis = inp.type === 'password';
    inp.type = vis ? 'text' : 'password';
    ico.className = vis ? 'fas fa-eye-slash' : 'fas fa-eye';
}
</script>

@endsection
