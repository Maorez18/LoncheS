<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'nickname' => 'required|string|max:40|unique:users',
            'name' => [
                'required',
                'string',
                'max:80',
                'regex:/^[\pL\s]+$/u', // Solo letras y espacios
            ],
            'lastname' => [
                'required',
                'string',
                'max:80',
                'regex:/^[\pL\s]+$/u', // Solo letras y espacios
            ],
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => ['required', 'date', 'before:today', function ($attribute, $value, $fail) {
                                $birthdate = \Carbon\Carbon::parse($value);
                                $age = \Carbon\Carbon::now()->diffInYears($birthdate);
//                                dd($age*(-1));
                                if ($age*(-1) < 18) {
                                    $fail('La edad debe ser mayor o igual a 18 años.');
                                } elseif ($age*(-1) >= 100) {
                                    $fail('La edad debe ser menor o igual a 100 años.');
                                }
                            }],
            'password' => [
                'required',
                'string',
                'min:8', // Asegura que la contraseña tenga al menos 8 caracteres
                'regex:/[A-Z]/', // Al menos una letra mayúscula
                'regex:/[a-z]/', // Al menos una letra minúscula
                'regex:/[0-9].*[0-9]/', // Al menos dos números
                'regex:/[@#$%^&*()_+{}\[\]:;"\'|,.<>?]/', // Al menos un carácter especial
                'confirmed', // Asegura que el campo password_confirmation coincida
            ],
        ];
        $messages = [
            'nickname.required' => 'El campo nombre de usuario es obligatorio.',
            'nickname.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
            'nickname.unique' => 'El nombre de usuario ya está en uso.',
            'nickname.max' => 'El nombre de usuario debe tener maximo 40 caracteres.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El nombre debe tener maximo 80 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'lastname.required' => 'El campo apellidos es obligatorio.',
            'lastname.max' => 'El apellidos debe tener maximo 80 caracteres.',
            'lastname.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.max' => 'El nickname debe tener maximo 255 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, dos números y un carácter especial.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.max' => 'La contraseña debe tener maximo 255 caracteres.',
            'birthdate.required' => 'El campo fecha de nacimiento es obligatorio.',
            'birthdate.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'birthdate.before' => 'La fecha de nacimiento debe ser antes de hoy.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $verification_code = rand(100000, 999999);

        User::create([
            'nickname' => $request->nickname,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'password' => Hash::make($request->password),
            'fk_type' => 2,
            'verification_code' => $verification_code,
        ]);

        Mail::send('emails.code-verification', ['code' => $verification_code, 'name'=>$request->name], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Codigo de Verificacion');
        });

        return redirect()->route('verification.notice')->with('success', 'Hemos enviado un correo con un codigo de verificacion al correo que proporcionaste!');
    }
}

