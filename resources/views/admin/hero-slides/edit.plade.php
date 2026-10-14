@extends('layouts.app')

@section('title', 'Edit Slide | WeSellGaris')
@section('meta_robots', 'noindex, nofollow')

@section('content')
<div class="hs-page">
    <div class="hs-head">
        <div>
            <h1>Edit <em>slide</em></h1>
            <p>Change the details, or upload a new image to replace the current one.</p>
        </div>
        <a href="{{ route('admin.hero-slides.index') }}" class="hs-btn hs-btn--ghost">← Back to all slides</a>
    </div>

    @if($errors->any())
        <div class="hs-alert hs-alert--err">
            <strong>Please fix the following:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <section class="hs-card">
        <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data" class="hs-form">
            @csrf
            @method('PUT')

            <div class="hs-field hs-field--full">
                <label>Current image</label>
                <div class="hs-thumb hs-thumb--big">
                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?? 'Slide' }}">
                </div>
            </div>

            <div class="hs-field hs-field--full">
                <label for="image">Replace image (optional)</label>
                <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp">
                <span class="hs-hint">Leave empty to keep the current image. PNG with transparent background works best. Max 5&nbsp;MB.</span>
            </div>
            <div class="hs-field">
                <label for="title">Name / description</label>
                <input type="text" id="title" name="title" maxlength="120" value="{{ old('title', $slide->title) }}">
            </div>
            <div class="hs-field">
                <label for="link_url">Link (optional)</label>
                <input type="url" id="link_url" name="link_url" value="{{ old('link_url', $slide->link_url) }}">
            </div>
            <div class="hs-field">
                <label for="sort_order">Order</label>
                <input type="number" id="sort_order" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $slide->sort_order) }}">
                <span class="hs-hint">Lower numbers show first.</span>
            </div>
            <div class="hs-field hs-field--check">
                <label class="hs-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}> Show on home page
                </label>
            </div>
            <div class="hs-field hs-field--full">
                <button type="submit" class="hs-btn">Save changes</button>
            </div>
        </form>
    </section>
</div>

<style>
.hs-page{max-width:980px;margin:0 auto;padding:36px 20px 80px;font-family:'DM Sans',ui-sans-serif,system-ui,sans-serif;color:#3A2920}
.hs-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:24px}
.hs-head h1{font-family:'DM Serif Display',Georgia,serif;font-weight:400;font-size:34px;line-height:1.1}
.hs-head h1 em{color:#D94F16}
.hs-head p{color:#8A7A6E;margin-top:6px;font-size:14px}
.hs-card{background:#FCFAF7;border:1px solid #EAD9C6;border-radius:16px;padding:22px;margin-bottom:22px}
.hs-form{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.hs-field{display:flex;flex-direction:column;gap:6px}
.hs-field--full{grid-column:1/-1}
.hs-field label{font-size:13px;font-weight:600}
.hs-field input[type=text],.hs-field input[type=url],.hs-field input[type=number],.hs-field input[type=file]{width:100%;padding:11px 12px;border:1.5px solid #EAD9C6;border-radius:10px;background:#fff;font:inherit;font-size:14px;color:#3A2920;outline:none}
.hs-field input:focus{border-color:#D94F16}
.hs-hint{font-size:12px;color:#8A7A6E}
.hs-field--check{justify-content:flex-end}
.hs-check{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:600;cursor:pointer}
.hs-btn{display:inline-flex;align-items:center;justify-content:center;background:#D94F16;color:#fff;border:none;border-radius:100px;padding:11px 24px;font:inherit;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;transition:background .2s;align-self:flex-start}
.hs-btn:hover{background:#B94314}
.hs-btn--ghost{background:transparent;color:#3A2920;border:1.5px solid #EAD9C6}
.hs-btn--ghost:hover{background:#F5EBDD}
.hs-alert{border-radius:12px;padding:14px 18px;margin-bottom:18px;font-size:14px}
.hs-alert--err{background:#FDF1EA;border:1px solid #f3c4a8;color:#8a2c0a}
.hs-alert ul{margin:8px 0 0 18px}
.hs-thumb{background:linear-gradient(135deg,#F5EBDD,#EAD9C6);border-radius:12px;display:flex;align-items:center;justify-content:center;overflow:hidden}
.hs-thumb--big{max-width:460px;aspect-ratio:16/10}
.hs-thumb img{max-width:100%;max-height:100%;object-fit:contain}
@media(max-width:760px){.hs-form{grid-template-columns:1fr}}
</style>
@endsection
