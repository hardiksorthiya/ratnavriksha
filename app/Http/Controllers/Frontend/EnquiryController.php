<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_name' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'quantity' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'comment' => 'nullable|string|max:2000',
        ]);

        Enquiry::create($validated);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been submitted successfully.');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Enquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'comment' => $validated['message'],
            'product_name' => 'Contact Page',
        ]);

        return back()->with('contact_success', 'Thank you! Your message has been sent successfully.');
    }
}
