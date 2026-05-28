<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function productIndex(): View
    {
        $enquiries = Enquiry::query()
            ->product()
            ->with('product')
            ->latest()
            ->paginate(20);

        return view('backend.pages.enquiries.product', compact('enquiries'));
    }

    public function contactIndex(): View
    {
        $enquiries = Enquiry::query()
            ->contact()
            ->latest()
            ->paginate(20);

        return view('backend.pages.enquiries.contact', compact('enquiries'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);
        $redirectRoute = $enquiry->isContact()
            ? 'enquiries.contact.index'
            : 'enquiries.product.index';

        $enquiry->delete();

        return redirect()
            ->route($redirectRoute)
            ->with('success', 'Enquiry deleted successfully.');
    }
}
