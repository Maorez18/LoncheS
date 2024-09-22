<?php

// app/Http/Controllers/Auth/VerificationController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function showVerificationForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $rules = [
            'code' => 'required|integer',
        ];
        $messages = [
            'code.required' => 'El campo codigo es obligatorio.',
            'code.integer' => 'El codigo debe ser un numero entero.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('verification_code', $request->code)
                    ->where('is_active', false)
                    ->first();

        if ($user) {
            $user->is_active = true;
            $user->verification_code = null;
            $user->email_verified_at = now();
            $user->save();

            return redirect()->route('login')->with('success', 'Verificacion exitosa. ¡Ahora puedes iniciar sesion!');
        }
        return back()->with('error', 'Error al verificar tu cuenta.');
    }
}
