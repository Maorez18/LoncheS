<?php

namespace App\Http\Controllers;

use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::orderBy('name', 'asc')->paginate(7);

        if ($user->fk_type == 1) {
            // Usuario administrador
            return view('crud.admin.list.user')->with('users', $users);
        } elseif ($user->fk_type != 1) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('user.profile');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $tuser = Auth::user();

        if ($tuser->fk_type == 1) {
            // Usuario administrador
            $types = TypeUser::orderBy('type_user', 'asc')->get();
            return view('crud.admin.crud.user', compact('types'))->with('user', $user);
        } elseif ($tuser->fk_type != 1) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('user.edit')->with('user', $user);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $tuser = Auth::user();

        if ($tuser->fk_type == 1) {
            // Usuario administrador
            $rules = [
                'nickname' => ['required', 'string', 'max:40', Rule::unique('users')->ignore($user->id)],
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
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
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
            ];
            $messages = [
                'nickname.required' => 'El campo nombre de usuario es obligatorio.',
                'nickname.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
                'nickname.unique' => 'El nombre de usuario ya está en uso por otro usuario.',
                'nickname.max' => 'El nombre de usuario debe tener maximo 40 caracteres.',
                'name.required' => 'El campo nombre es obligatorio.',
                'name.max' => 'El nombre debe tener maximo 80 caracteres.',
                'name.regex' => 'El nombre solo puede contener letras y espacios.',
                'lastname.required' => 'El campo apellidos es obligatorio.',
                'lastname.max' => 'El apellidos debe tener maximo 80 caracteres.',
                'lastname.regex' => 'Los apellidos solo pueden contener letras y espacios.',
                'email.required' => 'El campo correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
                'email.unique' => 'El correo electrónico ya está en uso por otro usuario.',
                'email.max' => 'El nickname debe tener maximo 255 caracteres.',
                'birthdate.required' => 'El campo fecha de nacimiento es obligatorio.',
                'birthdate.date' => 'La fecha de nacimiento debe ser una fecha válida.',
                'birthdate.before' => 'La fecha de nacimiento debe ser antes de hoy.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Actualizar otros campos del modelo
            $user->nickname = $request->nickname;
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->birthdate = $request->birthdate;
            $user->fk_type = $request->type;
            $user->is_active = $request->status;
            $user->email = $request->email;

            $user->save();

            Session::flash('mensaje', 'Edición exitosa');
//            return view('user.profile')->with('user', $user);
            return redirect()->route('users.index');
        } elseif ($tuser->fk_type !=1) {
            $rules = [
                'nickname' => ['required', 'string', 'max:40', Rule::unique('users')->ignore($user->id)],
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
            ];
            $messages = [
                'nickname.required' => 'El campo nombre de usuario es obligatorio.',
                'nickname.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
                'nickname.unique' => 'El nombre de usuario ya está en uso por otro usuario.',
                'nickname.max' => 'El nombre de usuario debe tener maximo 40 caracteres.',
                'name.required' => 'El campo nombre es obligatorio.',
                'name.max' => 'El nombre debe tener maximo 80 caracteres.',
                'name.regex' => 'El nombre solo puede contener letras y espacios.',
                'lastname.required' => 'El campo apellidos es obligatorio.',
                'lastname.max' => 'El apellidos debe tener maximo 80 caracteres.',
                'lastname.regex' => 'Los apellidos solo pueden contener letras y espacios.',
                'birthdate.required' => 'El campo fecha de nacimiento es obligatorio.',
                'birthdate.date' => 'La fecha de nacimiento debe ser una fecha válida.',
                'birthdate.before' => 'La fecha de nacimiento debe ser antes de hoy.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $filePath = base_path('public_html/uploads/users'); //Directorio donde se guardara el archivo de imagen en server
//            $filePath = public_path('uploads/users'); //Directorio donde se guardara el archivo de imagen en local

            if ($request->hasFile('photo')) {
                $file = $request->file('photo'); //Nombre original de la imagen
                $file_name = $request->nickname . 'picture.' . $file->getClientOriginalExtension(); //Cambio de nombre de la imagen
                $fullPath = $filePath . '/' . $file_name;

                // Eliminar el archivo existente si existe
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }

                // Mover el nuevo archivo
                $file->move($filePath, $file_name);

                // Asignar el nuevo nombre de archivo a la propiedad photo del modelo
                $user->photo = $file_name;
            }

            // Actualizar otros campos del modelo
            $user->nickname = $request->nickname;
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->birthdate = $request->birthdate;

            $user->save();

            Session::flash('mensaje', 'Edición exitosa');
//            return view('user.profile')->with('user', $user);
            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->fk_type==3){
            $user->inventory()->delete();
        }
        $user->delete();
        Session::flash('mensaje', 'Usuario eliminado');
        return redirect()->route('users.index');
    }

    public function getTypeUsers()
    {
        // Obtén los tipos de usuarios y su cantidad
        $userTypes = User::with('typeUser') // Cargar la relación
        ->select('fk_type', \DB::raw('count(*) as count'))
            ->where('fk_type', '!=', 1) // Excluir usuarios con fk_type = 1
            ->groupBy('fk_type')
            ->get();

        // Mapeo de datos para obtener los nombres de los tipos de usuarios
        $data = $userTypes->map(function($user) {
            return [
                'type' => $user->typeUser->type_user, // Acceder a la columna 'type' de la tabla relacionada
                'count' => $user->count
            ];
        });

        // Retorna los datos en formato JSON
        return response()->json($data);
    }

    public function getRegistrationData(Request $request)
    {
        $startDate = $request->query('startDate', now()->subMonth()->toDateString());
        $endDate = $request->query('endDate', now()->toDateString());

        // Filtrar los usuarios registrados en el rango de fechas seleccionado
        $registrations = User::select(\DB::raw('DATE(created_at) as date'),  \DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        return response()->json($registrations);
    }
}
