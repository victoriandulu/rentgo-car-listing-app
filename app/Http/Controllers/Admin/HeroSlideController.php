<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    /** List all slides + the "add slide" form. */
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.hero-slides.index', compact('slides'));
    }

    /** Add a new slide. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:120',
            'image'      => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
            'link_url'   => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active'  => 'nullable|boolean',
        ]);

        $path = $request->file('image')->store('hero-slides', 'public');

        HeroSlide::create([
            'title'      => $data['title'] ?? null,
            'image_path' => $path,
            'link_url'   => $data['link_url'] ?? null,
            'sort_order' => $data['sort_order'] ?? ((int) HeroSlide::max('sort_order') + 1),
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide added. It is now on the home page.');
    }

    /** Edit form. */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    /** Save changes (the image is only replaced if a new file is chosen). */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:120',
            'image'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'link_url'   => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active'  => 'nullable|boolean',
        ]);

        $update = [
            'title'      => $data['title'] ?? null,
            'link_url'   => $data['link_url'] ?? null,
            'sort_order' => $data['sort_order'] ?? $heroSlide->sort_order,
            'is_active'  => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('hero-slides', 'public');
            Storage::disk('public')->delete($heroSlide->image_path); // remove the old file
            $update['image_path'] = $newPath;
        }

        $heroSlide->update($update);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide updated.');
    }

    /** Show / hide a slide without deleting it. */
    public function toggle(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => ! $heroSlide->is_active]);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', $heroSlide->is_active ? 'Slide is now visible.' : 'Slide hidden from the home page.');
    }

    /** Delete a slide and its image file. */
    public function destroy(HeroSlide $heroSlide)
    {
        Storage::disk('public')->delete($heroSlide->image_path);
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide deleted.');
    }
}
