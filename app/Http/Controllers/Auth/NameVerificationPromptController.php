<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NameVerificationPromptController extends Controller
{
    /**
     * Display the name verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedName()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-name');
    }
}