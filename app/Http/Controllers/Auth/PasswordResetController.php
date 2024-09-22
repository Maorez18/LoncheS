<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm(){
        return view('auth.email-password');
    }

    public function sendResetLinkEmail(Request $request){
        $rules = [
            'email' => 'required|string|email|max:255|exists:users,email',
        ];
        $messages = [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.exists' => 'El correo electrónico proporcionado no está registrado en nuestro sistema.',
            'email.max' => 'El nickname debe tener maximo 255 caracteres.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = DB::table('users')
            ->select('nickname')
            ->where('email', $request->email)
            ->first();

        Mail::send('emails.reset-password', ['email'=>$request->email, 'name'=>$user->nickname], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reestablecimiento de contraseña');
        });

        return redirect()->route('login')->with('success', 'Hemos enviado un correo con un link para restablecer tu contraseña!');
    }

    public function showResetForm($email)
    {
        return view('auth.reset-password', ['email' => $email]);
    }

    public function reset(Request $request){
        $rules = [
            'email' => 'required|string|email|max:255|exists:users,email',
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
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.exists' => 'El correo electrónico ya está en uso.',
            'email.max' => 'El nickname debe tener maximo 255 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, dos números y un carácter especial.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.max' => 'La contraseña debe tener maximo 255 caracteres.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('login')->with('success', 'Contraseña actualizada exitosamente.');
        }else{
            return back()->with('error', 'Error al actualizar la contraseña.');
        }

    }
}
