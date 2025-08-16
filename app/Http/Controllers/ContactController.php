<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'message' => 'required|string|min:10',
        ]);

        // You can save to DB or send email here
        // Example: \Mail::to("rentgo@gmail.com")->send(new ContactMail($request->all()));

        return redirect()->route('contact')->with('success', 'Your message has been sent. We will get back to you shortly.');
    }
}
