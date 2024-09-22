<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->user)->orWhere('nickname', $request->user)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Verificar si la cuenta del usuario está activa
            if ($user->is_active) {
                // Iniciar sesión
                Auth::login($user);
                session(['user_id' => $user->id, 'user_type' => $user->fk_type, 'nickname'=>$user->nickname]);

                // Redirigir según el tipo de usuario
                if ($user->fk_type == 1) {
                    // Usuario administrador
                    return redirect('/admin');
                } else {
                    // Otro tipo de usuario
                    return redirect('/');
                }
            } else {
                // Cuenta no activa
                return back()->withErrors([
                    'error' => 'Tu cuenta no se encuentra activada. Por favor, verifica tu correo electronico',
                ]);
            }
        }

        return back()->withErrors([
            'error' => 'Credenciales no encontradas',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
