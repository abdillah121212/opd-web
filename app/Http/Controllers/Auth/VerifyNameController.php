<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NameVerificationRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class VerifyNameController extends Controller
{
    /**
     * Mark the authenticated user's name as verified.
     */
    public function __invoke(NameVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedName()) {
            return redirect()->intended(route(' ', absolute: false).'?verified=1');
        }

        if ($user->markNameAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}