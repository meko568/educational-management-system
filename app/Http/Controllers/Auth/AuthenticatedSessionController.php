<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return $this->localeView('auth.login');
    }
    public function rules()
    {
        return [
            'code' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function username()
    {
        return 'code';  // tells Breeze to use 'code' for login
    }
    public function store(Request $request)
    {
        $credentials = $request->only('code', 'password');
        
        // Explicitly use the 'student' guard and attempt to authenticate
        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->regenerate();

            // Check if the authenticated user is an admin
            $user = Auth::guard('student')->user();
            
            if ($user->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('student.dashboard'));
        }

        // Add an error if login fails
        return back()->withErrors([
            'code' => 'Invalid code or password.',
        ])->withInput();
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
