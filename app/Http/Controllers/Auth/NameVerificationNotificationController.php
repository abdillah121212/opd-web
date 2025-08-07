<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NameVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedName()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendNameVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
