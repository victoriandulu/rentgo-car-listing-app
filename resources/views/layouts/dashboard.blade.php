@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
      <span>Rent<em>Go</em></span>
    </div>

  </aside>

  {{-- ── Main ── --}}
  <main class="db-main">

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

  </main>

</div>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  /* Logo palette — only these three */
  --red:      #e53e3e;
  --red-deep: #c53030;
  --yellow:   #ffd700;
  --yellow-2: #f0c800;
  --ink:      #1a1206;
  --ink-2:    #2d2010;
  --ink-3:    #3d2e1e;

  /* Neutrals derived from ink */
  --ink-faint:  rgba(255,255,255,0.05);
  --ink-border: rgba(255,255,255,0.08);
  --ink-muted:  rgba(255,255,255,0.35);
  --ink-soft:   rgba(255,255,255,0.6);

  --bg:       #faf7f2;
  --bg-2:     #f3ede4;
  --border:   #e8ddd0;

  --font-d: 'Fraunces', Georgia, serif;
  --font-b: 'Plus Jakarta Sans', system-ui, sans-serif;
  --sidebar-w: 256px;
  --radius: 12px;
}

body { background: var(--bg); font-family: var(--font-b); color: var(--ink); }

/* ══ LAYOUT ══ */
.db-wrap {
  display: flex;
  min-height: 100vh;
  padding-top: 70px;
}

/* ══ SIDEBAR ══ */
.db-sidebar {
  width: var(--sidebar-w);
  flex-shrink: 0;
  background: var(--ink);
  display: flex;
  flex-direction: column;
  padding: 28px 18px 24px;
  position: fixed;
  top: 70px; left: 0; bottom: 0;
  overflow-y: auto;
  z-index: 100;
}

/* User card */
.db-user {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 14px;
  background: var(--ink-faint);
  border: 1px solid var(--ink-border);
  border-radius: var(--radius);
  margin-bottom: 28px;
}
.db-user__avatar {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--yellow);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-d);
  font-size: 1rem; font-weight: 600;
  color: var(--ink);
  flex-shrink: 0;
  box-shadow: 0 0 0 2px rgba(255,215,0,0.25);
}
.db-user__name {
  display: block;
  font-size: 0.88rem; font-weight: 600;
  color: #fff; line-height: 1.3;
}
.db-user__role {
  font-size: 0.69rem; font-weight: 400;
  color: var(--ink-muted);
  text-transform: uppercase; letter-spacing: 0.1em;
}

/* Section label */
.db-nav__label {
  font-size: 0.66rem; font-weight: 700;
  letter-spacing: 0.15em; text-transform: uppercase;
  color: rgba(255,255,255,0.2);
  padding: 0 6px;
  margin-bottom: 6px;
  display: block;
}

/* Nav */
.db-nav {
  display: flex; flex-direction: column; gap: 3px; flex: 1;
}
.db-nav__item {
  display: flex; align-items: center; gap: 11px;
  padding: 11px 13px;
  border-radius: 9px;
  text-decoration: none;
  font-size: 0.88rem; font-weight: 500;
  color: var(--ink-soft);
  transition: all 0.18s ease;
  position: relative;
}
.db-nav__item:hover {
  background: rgba(255,255,255,0.07);
  color: #fff;
  text-decoration: none;
}
/* Active — yellow accent bar + red bg */
.db-nav__item.is-active {
  background: var(--red);
  color: #fff;
  box-shadow: 0 4px 18px rgba(229,62,62,0.38);
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
  padding-top: 20px;
  border-top: 1px solid var(--ink-border);
  text-align: center;
}
.db-brand span {
  font-family: var(--font-d);
  font-size: 1.25rem; font-weight: 600;
  color: rgba(255,255,255,0.15);
  letter-spacing: -0.01em;
}
.db-brand em {
  font-style: italic;
  color: rgba(255,215,0,0.3);
}

/* ══ MAIN ══ */
.db-main {
  flex: 1;
  margin-left: var(--sidebar-w);
  display: flex;
  flex-direction: column;
  min-height: calc(100vh - 70px);
  background: var(--bg);
}

/* Topbar */
.db-topbar {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  padding: 32px 36px 0;
  margin-bottom: 28px;
  border-bottom: 1px solid var(--border);
  padding-bottom: 24px;
}
.db-topbar__eyebrow {
  font-size: 0.72rem; font-weight: 600;
  text-transform: uppercase; letter-spacing: 0.14em;
  color: var(--red);
  margin-bottom: 4px;
  display: flex; align-items: center; gap: 6px;
}
.db-topbar__eyebrow::before {
  content: '';
  width: 20px; height: 2px;
  background: var(--yellow);
  border-radius: 1px;
  display: inline-block;
}
.db-topbar__title {
  font-family: var(--font-d);
  font-size: clamp(1.4rem, 2.5vw, 1.9rem);
  font-weight: 400;
  color: var(--ink);
  line-height: 1.1;
}

.db-back-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 0.8rem; font-weight: 600;
  color: var(--ink-3);
  text-decoration: none;
  padding: 8px 16px;
  border: 1.5px solid var(--border);
  border-radius: 50px;
  background: #fff;
  transition: all 0.18s;
  letter-spacing: 0.02em;
  white-space: nowrap;
}
.db-back-btn:hover {
  border-color: var(--red);
  color: var(--red);
  text-decoration: none;
  background: rgba(229,62,62,0.04);
}

/* Content */
.db-content {
  flex: 1;
  padding: 0 36px 52px;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 860px) {
  :root { --sidebar-w: 220px; }
  .db-topbar, .db-content { padding-left: 24px; padding-right: 24px; }
}

@media (max-width: 640px) {
  .db-wrap { flex-direction: column; }
  .db-sidebar {
    width: 100%; position: static;
    flex-direction: row; align-items: center;
    padding: 10px 14px; gap: 6px;
    overflow-x: auto;
  }
  .db-user { display: none; }
  .db-nav__label { display: none; }
  .db-nav { flex-direction: row; flex: unset; gap: 4px; }
  .db-nav__item { padding: 8px 13px; font-size: 0.8rem; white-space: nowrap; }
  .db-nav__icon svg { width: 14px; height: 14px; }
  .db-nav__item.is-active::before { display: none; }
  .db-brand { display: none; }
  .db-main { margin-left: 0; }
  .db-topbar { padding: 16px 16px 12px; flex-wrap: wrap; gap: 12px; }
  .db-content { padding: 0 16px 32px; }
}
</style>

@endsection
