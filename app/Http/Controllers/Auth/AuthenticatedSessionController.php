<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $user = User::all();

        foreach ($user as $users) {

             if($users->email == $request->get('email')){
                 $verified_user = $users;
             }
        }

        $request->authenticate();

        $request->session()->regenerate();

      if($verified_user->email == 'admin@eventbookins.co.za'){

            $identifier = 'admin';

        }
        else{
            $identifier = $verified_user->role;

        }

        //dd($identifier);

        return redirect()->intended(route('dashboard', ['identifier' => $identifier], absolute: false));

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
