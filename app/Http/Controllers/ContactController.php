<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->contact = $request->contact;
        $user->save();

        return redirect()->route('welcome')->with('success', 'Contact information saved successfully.');
    }
}
