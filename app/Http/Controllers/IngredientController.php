<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryIngredient;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->fk_type==1){
            $query = Ingredient::query();

            // Filtrado por categoría
            if ($request->has('category') && !empty($request->category)) {
                $categories = $request->category;
                $query->whereIn('fk_category', $categories);
            }

            // Búsqueda por texto
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('ingredient', 'like', "%{$search}%");
            }

            $ingredients = $query->orderBy('ingredient', 'asc')->paginate(12);
            $categories = CategoryIngredient::orderBy('category', 'asc')->get(); // Asegúrate de tener esta variable disponible para el filtro

            return view('crud.admin.list.ingredient', compact('ingredients', 'categories'));
        } elseif ($user->fk_type != 1) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('profile');
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $categories = CategoryIngredient::orderBy('category', 'asc')->get();

        if ($user->fk_type == 1) {
            // Usuario administrador
            return view('crud.admin.crud.ingredient', compact('categories'));
        } elseif ($user->fk_type == 3) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('crud.user.crud.ingredient', compact('categories'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'ingredient'=> 'required|string|max:30|unique:ingredients',
            'calories'=>'numeric|nullable|max:1000',
            'protein'=>'numeric|nullable|max:1000',
            'carbo'=>'numeric|nullable|max:1000',
            'fiber'=>'numeric|nullable|max:1000',
            'sodium'=>'numeric|nullable|max:1000',
            'fat'=>'numeric|nullable|max:1000',
            'category'=> 'required|exists:category_ingredients,id',
            'photo'=> 'mimes:png,jpg,jpge,svg,webp',
        ];
        $messages = [
            'ingredient.required' => 'El campo nombre es obligatorio.',
            'ingredient.unique' => 'Ya existe un ingrediente con este nombre.',
            'ingredient.max' => 'El nombre debe tener maximo 30 caracteres.',
            'calories.numeric' => 'El campo debe ser un numero.',
            'calories.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'protein.numeric' => 'El campo debe ser un numero.',
            'protein.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'carbo.numeric' => 'El campo debe ser un numero.',
            'carbo.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'fiber.numeric' => 'El campo debe ser un numero.',
            'fiber.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'sodium.numeric' => 'El campo debe ser un numero.',
            'sodium.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'fat.numeric' => 'El campo debe ser un numero.',
            'fat.max' => 'El valor de este atributo no debe ser mayor a 1000.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = base_path('public_html/uploads/ingredients');

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $file_name = $request->ingredient.'picture.'.$file->getClientOriginalExtension();
            $file->move($filePath, $file_name);
        } else{
            $file_name = NULL;
        }

        Ingredient::create([
            'ingredient' => $request->ingredient,
            'calories' => $request->calories,
            'protein' => $request->protein,
            'carbohydrates' => $request->carbo,
            'fiber' => $request->fiber,
            'sodium' => $request->sodium,
            'saturated_fat' => $request->fat,
            'fk_category' => $request->category,
            'photo' => $file_name,
        ]);

        Session::flash('mensaje', 'Registro exitoso');

        if ($user->fk_type == 1){
            return redirect()->route('ingredients.index');
        }else{
            return redirect()->route('inventory.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        $user = Auth::user();

        if ($user->fk_type == 1) {
            // Usuario administrador
            $categories = CategoryIngredient::orderBy('category', 'asc')->get();
            return view('crud.admin.crud.ingredient', compact('categories'))->with('ingredient', $ingredient);
        } elseif ($user->fk_type != 1) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('profile');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $rules = [
            'ingredient'=> 'required|string|max:30|unique:ingredients',
            'calories'=>'numeric|nullable|max:1000',
            'protein'=>'numeric|nullable|max:1000',
            'carbo'=>'numeric|nullable|max:1000',
            'fiber'=>'numeric|nullable|max:1000',
            'sodium'=>'numeric|nullable|max:1000',
            'fat'=>'numeric|nullable|max:1000',
            'category'=> 'required|exists:category_ingredients,id',
            'photo'=> 'mimes:png,jpg,jpge,svg,webp',
        ];
        $messages = [
            'ingredient.required' => 'El campo nombre es obligatorio.',
            'ingredient.unique' => 'Ya existe un ingrediente con este nombre.',
            'ingredient.max' => 'El nombre debe tener maximo 30 caracteres.',
            'calories.numeric' => 'El campo debe ser un numero.',
            'calories.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'protein.numeric' => 'El campo debe ser un numero.',
            'protein.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'carbo.numeric' => 'El campo debe ser un numero.',
            'carbo.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'fiber.numeric' => 'El campo debe ser un numero.',
            'fiber.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'sodium.numeric' => 'El campo debe ser un numero.',
            'sodium.max' => 'El valor de este atributo no debe ser mayor a 1000.',
            'fat.numeric' => 'El campo debe ser un numero.',
            'fat.max' => 'El valor de este atributo no debe ser mayor a 1000.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = base_path('public_html/uploads/ingredients'); //Directorio donde se guardara el archivo de imagen en server
//        $filePath = base_path('public/uploads/ingredients'); //Directorio donde se guardara el archivo de imagen en local

        if ($request->hasFile('photo')) {
            $file = $request->file('photo'); //Nombre original de la imagen
            $file_name = $request->ingredient . 'picture.' . $file->getClientOriginalExtension(); //Cambio de nombre de la imagen
            $fullPath = $filePath . '/' . $file_name;

            // Eliminar el archivo existente si existe
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Mover el nuevo archivo
            $file->move($filePath, $file_name);

            // Asignar el nuevo nombre de archivo a la propiedad photo del modelo
            $ingredient->photo = $file_name;
        }

        // Actualizar otros campos del modelo
        $ingredient->ingredient = $request->ingredient;
        $ingredient->calories = $request->calories;
        $ingredient->protein = $request->protein;
        $ingredient->carbohydrates = $request->carbo;
        $ingredient->fiber = $request->fiber;
        $ingredient->sodium = $request->sodium;
        $ingredient->saturated_fat = $request->fat;
        $ingredient->fk_category = $request->category;

        $ingredient->save();

        Session::flash('mensaje', 'Edición exitosa');

        return redirect()->route('ingredients.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingre = Ingredient::find($ingredient->id);
        $recipes = $ingre->recipes->count();
        if($recipes == 0){
            $ingredient->delete();
            Session::flash('mensaje', 'Registro Eliminado');
            return redirect()->route('ingredients.index');
        }
        return redirect()->back()->with('error', 'No se puede eliminar el ingrediente porque está relacionado con una o más recetas.');
    }
    // Funcion para buscar ingredientes
    public function search(Request $request)
    {
        $term = $request->get('query');
        $ingredients = Ingredient::where('ingredient', 'LIKE', '%' . $term . '%')->get();

        return response()->json($ingredients);
    }

}
