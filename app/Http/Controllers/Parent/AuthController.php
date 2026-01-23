<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return $this->localeView('parent.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'code' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('parent')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('parent.dashboard'));
        }

        return back()->withErrors([
            'code' => 'Invalid code or password.',
        ])->withInput();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('parent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('parent.login');
    }
}
