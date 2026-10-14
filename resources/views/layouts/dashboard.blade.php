@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="db-wrap">

  {{-- ── Sidebar ── --}}
  <aside class="db-sidebar">

    {{-- User card --}}
    <div class="db-user">
      <div class="db-user__avatar">
        {{ strtoupper(substr(auth()->user()->first_name ?? 'U', 0, 1)) }}
      </div>
      <div class="db-user__info">
        <span class="db-user__name">{{ auth()->user()->first_name ?? 'User' }}</span>
        <span class="db-user__role">Car Owner</span>
      </div>
    </div>

    <span class="db-nav__label">Menu</span>

    <nav class="db-nav">
      <a href="{{ route('cars.create') }}"
         class="db-nav__item {{ request()->routeIs('cars.create') ? 'is-active' : '' }}">
        <span class="db-nav__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14"/>
          </svg>
        </span>
        <span>List Your Car</span>
      </a>

      <a href="{{ route('cars.my') }}"
         class="db-nav__item {{ request()->routeIs('cars.my') ? 'is-active' : '' }}">
        <span class="db-nav__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
          </svg>
        </span>
        <span>Listed Cars</span>
      </a>

      <a href="{{ route('profile.edit') }}"
         class="db-nav__item {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}">
        <span class="db-nav__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
          </svg>
        </span>
        <span>My Profile</span>
      </a>
    </nav>

    {{-- Brand --}}
    <div class="db-brand">
      <span>WeSell<em>Garis</em></span>
    </div>

  </aside>

  {{-- ── Main ── --}}
  <div class="db-main">

    <header class="db-topbar">
      <div class="db-topbar__left">
        <div class="db-topbar__eyebrow">Dashboard</div>
        <h2 class="db-topbar__title">
          @hasSection('page-title')
            @yield('page-title')
          @else
            Welcome back, {{ auth()->user()->first_name ?? 'User' }}
          @endif
        </h2>
      </div>
      <a href="{{ url('/') }}" class="db-back-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
          <path d="M15 18l-6-6 6-6"/>
        </svg>
        Back to site
      </a>
    </header>

    <div class="db-content">
      @yield('dashboard-content')
    </div>

  </div>

</div>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  /* Brand palette (same as the home page). Old variable names are kept so
     the dashboard pages that use them pick up the new colours automatically. */
  --red:      #D94F16;   /* burnt orange */
  --red-deep: #B94314;
  --yellow:   #F5C400;
  --yellow-2: #E0B400;
  --ink:      #3A2920;   /* espresso */
  --ink-2:    #4A362B;
  --ink-3:    #5C4538;

  /* Neutrals derived from ink */
  --ink-faint:  rgba(255,255,255,0.06);
  --ink-border: rgba(255,255,255,0.10);
  --ink-muted:  rgba(255,255,255,0.45);
  --ink-soft:   rgba(255,255,255,0.72);

  --bg:       #F5EBDD;   /* cream */
  --bg-2:     #EFE0CE;
  --border:   #EAD9C6;   /* beige */
  --peach:    #F3D7C8;

  --font-d: 'Playfair Display', Georgia, serif;
  --font-b: 'Inter', system-ui, sans-serif;
  --sidebar-w: 256px;
  --nav-h: 68px;          /* height of the sticky site navbar */
  --radius: 14px;
}

body { background: var(--bg); font-family: var(--font-b); color: var(--ink); }

/* ══ LAYOUT ══ */
.db-wrap {
  display: flex;
  align-items: flex-start;
  min-height: calc(100vh - var(--nav-h));
}

/* ══ SIDEBAR (sticks under the navbar, stops before the footer) ══ */
.db-sidebar {
  width: var(--sidebar-w);
  flex-shrink: 0;
  background: var(--ink);
  display: flex;
  flex-direction: column;
  padding: 26px 16px 22px;
  position: sticky;
  top: var(--nav-h);
  height: calc(100vh - var(--nav-h));
  overflow-y: auto;
  z-index: 90;
}

/* User card */
.db-user {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px;
  background: var(--ink-faint);
  border: 1px solid var(--ink-border);
  border-radius: var(--radius);
  margin-bottom: 26px;
}
.db-user__avatar {
  width: 42px; height: 42px;
  border-radius: 50%;
  background: var(--yellow);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-d);
  font-size: 1.05rem; font-weight: 700;
  color: var(--ink);
  flex-shrink: 0;
  box-shadow: 0 0 0 3px rgba(245,196,0,0.25);
}
.db-user__info { min-width: 0; }
.db-user__name {
  display: block;
  font-size: 0.9rem; font-weight: 600;
  color: #fff; line-height: 1.3;
  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.db-user__role {
  font-size: 0.66rem; font-weight: 500;
  color: var(--ink-muted);
  text-transform: uppercase; letter-spacing: 0.12em;
}

/* Section label */
.db-nav__label {
  font-size: 0.64rem; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase;
  color: rgba(255,255,255,0.3);
  padding: 0 8px;
  margin-bottom: 8px;
  display: block;
}

/* Nav */
.db-nav {
  display: flex; flex-direction: column; gap: 4px; flex: 1;
}
.db-nav__item {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 14px;
  border-radius: 12px;
  text-decoration: none;
  font-size: 0.88rem; font-weight: 500;
  color: var(--ink-soft);
  transition: background .18s ease, color .18s ease, transform .18s ease;
  position: relative;
}
.db-nav__item:hover {
  background: rgba(255,255,255,0.08);
  color: #fff;
  text-decoration: none;
}
.db-nav__item:focus-visible { outline: 3px solid var(--yellow); outline-offset: 2px; }
/* Active: orange pill + yellow accent bar */
.db-nav__item.is-active {
  background: var(--red);
  color: #fff;
  box-shadow: 0 6px 20px rgba(217,79,22,0.38);
}
.db-nav__item.is-active::before {
  content: '';
  position: absolute;
  left: 0; top: 25%; bottom: 25%;
  width: 3px;
  background: var(--yellow);
  border-radius: 0 2px 2px 0;
}
.db-nav__icon { width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.db-nav__icon svg { width: 17px; height: 17px; }

/* Brand mark */
.db-brand {
  margin-top: auto;
  padding-top: 18px;
  border-top: 1px solid var(--ink-border);
  text-align: center;
}
.db-brand span {
  font-family: var(--font-d);
  font-size: 1.2rem; font-weight: 600;
  color: rgba(255,255,255,0.28);
  letter-spacing: -0.01em;
}
.db-brand em {
  font-style: italic;
  color: rgba(245,196,0,0.55);
}

/* ══ MAIN ══ */
.db-main {
  flex: 1;
  min-width: 0;               /* lets wide tables/cards shrink instead of overflowing */
  display: flex;
  flex-direction: column;
  min-height: calc(100vh - var(--nav-h));
  background: var(--bg);
}

/* Topbar */
.db-topbar {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 16px;
  padding: 32px 36px 24px;
  margin-bottom: 28px;
  border-bottom: 1px solid var(--border);
}
.db-topbar__eyebrow {
  font-size: 0.7rem; font-weight: 600;
  text-transform: uppercase; letter-spacing: 0.14em;
  color: var(--red);
  margin-bottom: 6px;
  display: flex; align-items: center; gap: 8px;
}
.db-topbar__eyebrow::before {
  content: '';
  width: 22px; height: 2px;
  background: var(--yellow);
  border-radius: 1px;
  display: inline-block;
}
.db-topbar__title {
  font-family: var(--font-d);
  font-size: clamp(1.45rem, 2.6vw, 2.1rem);
  font-weight: 600;
  color: var(--ink);
  line-height: 1.15;
}

.db-back-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 0.8rem; font-weight: 600;
  color: var(--ink);
  text-decoration: none;
  padding: 10px 18px;
  min-height: 40px;
  border: 1px solid var(--border);
  border-radius: 50px;
  background: #fff;
  box-shadow: 0 2px 8px rgba(58,41,32,0.06);
  transition: all .18s;
  white-space: nowrap;
  flex-shrink: 0;
}
.db-back-btn:hover {
  border-color: var(--red);
  color: #fff;
  background: var(--red);
  text-decoration: none;
  transform: translateY(-1px);
}
.db-back-btn:focus-visible { outline: 3px solid var(--yellow); outline-offset: 2px; }

/* Content */
.db-content {
  flex: 1;
  padding: 0 36px 56px;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1000px) {
  :root { --sidebar-w: 220px; }
  .db-topbar, .db-content { padding-left: 24px; padding-right: 24px; }
}

@media (max-width: 900px) {
  :root { --nav-h: 62px; }   /* the navbar is slightly shorter on small screens */
}

/* Small screens: sidebar becomes a swipeable pill bar under the navbar */
@media (max-width: 820px) {
  .db-wrap { flex-direction: column; align-items: stretch; }
  .db-sidebar {
    width: 100%;
    height: auto;
    position: sticky; top: var(--nav-h);
    flex-direction: row; align-items: center;
    padding: 10px 14px; gap: 6px;
    overflow-x: auto; overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    box-shadow: 0 6px 16px rgba(58,41,32,0.18);
  }
  .db-sidebar::-webkit-scrollbar { display: none; }
  .db-user { display: none; }
  .db-nav__label { display: none; }
  .db-nav { flex-direction: row; flex: unset; gap: 6px; }
  .db-nav__item { padding: 10px 16px; font-size: 0.82rem; white-space: nowrap; border-radius: 50px; min-height: 42px; }
  .db-nav__icon svg { width: 15px; height: 15px; }
  .db-nav__item.is-active::before { display: none; }
  .db-brand { display: none; }
  .db-main { min-height: 0; }
  .db-topbar { padding: 22px 18px 18px; margin-bottom: 20px; }
  .db-content { padding: 0 18px 36px; }
}

@media (max-width: 520px) {
  .db-sidebar { padding: 8px 10px; gap: 4px; }
  .db-nav { gap: 4px; }
  .db-nav__item { padding: 9px 12px; font-size: 0.78rem; gap: 7px; }
  .db-topbar { flex-direction: column; align-items: flex-start; gap: 14px; }
  .db-back-btn { align-self: flex-start; }
}
</style>

@endsection
