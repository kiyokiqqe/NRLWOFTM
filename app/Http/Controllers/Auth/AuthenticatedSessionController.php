<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Показати форму входу.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Обробити запит на автентифікацію.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Вхід з урахуванням прапорця "запам'ятати мене"
        Auth::login($request->user(), $request->filled('remember'));

        // Додати прапорець в сесію для привітання
        $request->session()->put('just_logged_in', true);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Вихід з системи.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
