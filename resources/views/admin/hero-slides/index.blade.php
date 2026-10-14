@extends('layouts.app')

@section('title', 'Manage Home Slides | WeSellGaris')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<div class="hs-page">
    <div class="hs-head">
        <div>
            <h1>Home page <em>slides</em></h1>
            <p>Add, edit, reorder, hide or delete the car images that slide across the home page.</p>
        </div>
        <a href="{{ url('/') }}" class="hs-btn hs-btn--ghost" target="_blank">View home page ↗</a>
    </div>

    @if(session('success'))
        <div class="hs-alert hs-alert--ok">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="hs-alert hs-alert--err">
            <strong>Please fix the following:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ── Add a slide ── --}}
    <section class="hs-card">
        <h2>Add a new slide</h2>
        <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="hs-form">
            @csrf
            <div class="hs-field hs-field--full">
                <label for="image">Car image <span class="hs-req">*</span></label>
                <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp" required>
                <span class="hs-hint">Best: a car photo with a <strong>transparent background (PNG)</strong>, side or front view, wheels near the bottom edge. Max 5&nbsp;MB.</span>
            </div>
            <div class="hs-field">
                <label for="title">Name / description</label>
                <input type="text" id="title" name="title" maxlength="120" placeholder="e.g. Mercedes G-Wagon" value="{{ old('title') }}">
                <span class="hs-hint">Used as the image's alt text (helps SEO and accessibility).</span>
            </div>
            <div class="hs-field">
                <label for="link_url">Link (optional)</label>
                <input type="url" id="link_url" name="link_url" placeholder="https://wesellgaris.com/vehicles/12" value="{{ old('link_url') }}">
                <span class="hs-hint">Where a click on the slide goes. Leave empty for no link.</span>
            </div>
            <div class="hs-field">
                <label for="sort_order">Order</label>
                <input type="number" id="sort_order" name="sort_order" min="0" max="9999" placeholder="Auto (goes last)" value="{{ old('sort_order') }}">
                <span class="hs-hint">Lower numbers show first.</span>
            </div>
            <div class="hs-field hs-field--check">
                <label class="hs-check">
                    <input type="checkbox" name="is_active" value="1" checked> Show on home page
                </label>
            </div>
            <div class="hs-field hs-field--full">
                <button type="submit" class="hs-btn">Add slide</button>
            </div>
        </form>
    </section>

    {{-- ── Current slides ── --}}
    <section class="hs-card">
        <h2>Current slides <span class="hs-count">{{ $slides->count() }}</span></h2>

        @if($slides->isEmpty())
            <p class="hs-empty">No slides yet. The home page is showing its built-in default cars until you add your first slide here.</p>
        @else
            <div class="hs-list">
                @foreach($slides as $slide)
                    <article class="hs-item {{ $slide->is_active ? '' : 'is-hidden' }}">
                        <div class="hs-thumb">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?? 'Slide' }}" loading="lazy">
                        </div>
                        <div class="hs-info">
                            <strong>{{ $slide->title ?: 'Untitled slide' }}</strong>
                            <span class="hs-meta">
                                Order: {{ $slide->sort_order }} ·
                                <span class="hs-badge {{ $slide->is_active ? 'ok' : 'off' }}">{{ $slide->is_active ? 'Visible' : 'Hidden' }}</span>
                            </span>
                            @if($slide->link_url)
                                <a href="{{ $slide->link_url }}" target="_blank" rel="noopener" class="hs-link">{{ \Illuminate\Support\Str::limit($slide->link_url, 50) }}</a>
                            @endif
                        </div>
                        <div class="hs-actions">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="hs-btn hs-btn--sm">Edit</a>

                            <form action="{{ route('admin.hero-slides.toggle', $slide) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="hs-btn hs-btn--sm hs-btn--ghost">{{ $slide->is_active ? 'Hide' : 'Show' }}</button>
                            </form>

                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST"
                                  onsubmit="return confirm('Delete this slide permanently? This also removes the image file.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="hs-btn hs-btn--sm hs-btn--danger">Delete</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>

<style>
.hs-page{max-width:980px;margin:0 auto;padding:36px 20px 80px;font-family:'DM Sans',ui-sans-serif,system-ui,sans-serif;color:#3A2920}
.hs-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:24px}
.hs-head h1{font-family:'DM Serif Display',Georgia,serif;font-weight:400;font-size:34px;line-height:1.1}
.hs-head h1 em{color:#D94F16}
.hs-head p{color:#8A7A6E;margin-top:6px;font-size:14px}
.hs-card{background:#FCFAF7;border:1px solid #EAD9C6;border-radius:16px;padding:22px;margin-bottom:22px}
.hs-card h2{font-size:17px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.hs-count{background:#F5EBDD;border-radius:100px;padding:2px 10px;font-size:12px;font-weight:600}
.hs-form{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.hs-field{display:flex;flex-direction:column;gap:6px}
.hs-field--full{grid-column:1/-1}
.hs-field label{font-size:13px;font-weight:600}
.hs-req{color:#D94F16}
.hs-field input[type=text],.hs-field input[type=url],.hs-field input[type=number],.hs-field input[type=file]{width:100%;padding:11px 12px;border:1.5px solid #EAD9C6;border-radius:10px;background:#fff;font:inherit;font-size:14px;color:#3A2920;outline:none}
.hs-field input:focus{border-color:#D94F16}
.hs-hint{font-size:12px;color:#8A7A6E}
.hs-field--check{justify-content:flex-end}
.hs-check{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:600;cursor:pointer}
.hs-btn{display:inline-flex;align-items:center;justify-content:center;background:#D94F16;color:#fff;border:none;border-radius:100px;padding:11px 24px;font:inherit;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:background .2s}
.hs-btn:hover{background:#B94314}
.hs-btn--ghost{background:transparent;color:#3A2920;border:1.5px solid #EAD9C6}
.hs-btn--ghost:hover{background:#F5EBDD}
.hs-btn--danger{background:#3A2920}
.hs-btn--danger:hover{background:#7a1f12}
.hs-btn--sm{padding:8px 16px;font-size:13px}
.hs-alert{border-radius:12px;padding:14px 18px;margin-bottom:18px;font-size:14px}
.hs-alert--ok{background:#e8f5ee;border:1px solid #bfe3cf;color:#1a7a45}
.hs-alert--err{background:#FDF1EA;border:1px solid #f3c4a8;color:#8a2c0a}
.hs-alert ul{margin:8px 0 0 18px}
.hs-empty{color:#8A7A6E;font-size:14px}
.hs-list{display:flex;flex-direction:column;gap:12px}
.hs-item{display:grid;grid-template-columns:170px 1fr auto;gap:16px;align-items:center;background:#fff;border:1px solid #EAD9C6;border-radius:14px;padding:12px}
.hs-item.is-hidden{opacity:.6}
.hs-thumb{background:linear-gradient(135deg,#F5EBDD,#EAD9C6);border-radius:10px;aspect-ratio:16/10;display:flex;align-items:center;justify-content:center;overflow:hidden}
.hs-thumb img{max-width:100%;max-height:100%;object-fit:contain}
.hs-info{display:flex;flex-direction:column;gap:5px;min-width:0}
.hs-meta{font-size:12.5px;color:#8A7A6E}
.hs-badge{border-radius:100px;padding:2px 9px;font-weight:600;font-size:11.5px}
.hs-badge.ok{background:#e8f5ee;color:#1a7a45}
.hs-badge.off{background:#EAD9C6;color:#5c4f44}
.hs-link{font-size:12.5px;color:#D94F16;text-decoration:none;word-break:break-all}
.hs-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end}
.hs-actions form{margin:0}
@media(max-width:760px){
  .hs-form{grid-template-columns:1fr}
  .hs-item{grid-template-columns:1fr}
  .hs-actions{justify-content:flex-start}
}
</style>
@endsection
