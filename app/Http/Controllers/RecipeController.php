<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientInventory;
use App\Models\Recipe;
use App\Models\TypeRecipe;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Recipe::query();

        // Filtrado por categoría
        if ($request->has('category') && !empty($request->category)) {
            $categories = $request->category;
            $query->whereIn('fk_type_recipe', $categories);
        }

        // Búsqueda por texto
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $recipes = $query->orderBy('name', 'asc')->with('ingredients.unit')->paginate(7);
        $categories = TypeRecipe::orderBy('type_recipe', 'asc')->get();

        if ($user != null) { //validacion de si hay o no un usuario autenticado
            if ($user->fk_type == 1) { // Usuario administrador
                return view('crud.admin.list.recipe', compact('categories'))->with('recipes', $recipes);
            } elseif ($user->fk_type != 1) { // Otro tipo de usuario
                return view('recipes.recipes', compact('categories'))->with('recipes', $recipes);
            }
        }else{
            return view('recipes.recipes', compact('categories'))->with('recipes', $recipes);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $ingredients = Ingredient::orderBy('ingredient', 'asc')->get();
        $units = Unit::orderBy('unit', 'asc')->get();
        $typerecipes = TypeRecipe::orderBy('type_recipe', 'asc')->get();

        if ($user != null) { //validacion de si hay o no un usuario autenticado
            if ($user->fk_type == 1) { // Usuario administrador
                return view('crud.admin.crud.recipe', compact('ingredients', 'units', 'typerecipes'));
            } elseif ($user->fk_type != 1) { // Otro tipo de usuario
                return view('crud.user.crud.recipe', compact('ingredients', 'units', 'typerecipes'));
            }
        }else{
            return view('welcome');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'time' => 'required|integer|min:1|max:1440',
            'description' => 'required|string|max:280',
            'preparation' => 'required|string',
            'ingredients' => 'required|array',
            'category' => 'required|exists:type_recipes,id',
            'photo' => 'nullable|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ];
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El nombre debe tener maximo 255 caracteres.',
            'time.max' => 'El tiempo no puede ser superior a 1440',
            'description.required' => 'Las descripcion de la receta es obligatoria.',
            'description.max' => 'Las descripcion no debe tener maximo 280 caracteres.',
            'preparation.required' => 'Debes agregar al menos un paso.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = base_path('public_html/uploads/recipes');
        //$filePath = public_path('uploads/recipes');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $file_name = $request->name . 'picture.' . $file->getClientOriginalExtension();
            $file->move($filePath, $file_name);
        } else {
            $file_name = NULL;
        }

        $recipe = Recipe::create([
            'name' => $request->name,
            'time' => $request->time,
            'description' => $request->description,
            'preparation' => $request->preparation,
            'photo' => $file_name,
            'fk_type_recipe' => $request->category,
            'fk_creator_recipe' => Auth::user()->id,
        ]);

        $ingredients = $request->input('ingredients'); // Array de ingredientes con cantidad y fk_unit
        foreach ($ingredients as $ingredientId => $ingredientData) {
            $recipe->ingredients()->attach($ingredientId, [
                'quantity' => $ingredientData['quantity'],
                'fk_unit' => $ingredientData['unit_id'] // Usa fk_unit
            ]);
        }

        if (Auth::user()->id == 1){
            return redirect()->route('recipes.index')->with('mensaje', 'Receta creada exitosamente.');
        }else{
            return redirect()->route('recipes.user')->with('mensaje', 'Receta creada exitosamente.');
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        // Dividir los pasos y eliminar los espacios en blanco al principio y al final de cada paso
        $preparations = array_map('trim', explode("@", $recipe->preparation));

        $isFavorite = false;
        $ingredientInventories = [];

        if (auth()->check()) {
            $user = Auth::user();
            if ($user->fk_type == 3 && $user->inventory) {
                $ingredientInventories = $user->inventory->ingredients()
                    ->select('ingredient_inventories.quantity', 'ingredient_inventories.fk_unit', 'ingredients.id as ingredient_id')
                    ->get();
                // Contar los ingredientes de la receta
                $totalIngredients = $recipe->ingredients->count();

                // Contar los ingredientes de la receta que están en el inventario del usuario
                $ingredientsInInventory = $recipe->ingredients->filter(function($ingredient) use ($ingredientInventories) {
                    return $ingredientInventories->firstWhere('ingredient_id', $ingredient->id);
                })->count();

                // Calcular el porcentaje de ingredientes que el usuario tiene
                $percentage = ($totalIngredients > 0) ? ($ingredientsInInventory / $totalIngredients) * 100 : 0;
            }

            // Verificar si la receta está marcada como favorita
            $isFavorite = $user->recipes()->wherePivot('fk_recipe', $recipe->id)
                ->wherePivot('is_favorite', true)
                ->exists();
        }

        // Cargar comentarios relacionados con la receta
        $comments = $recipe->comments()->with('user')->get();

        // Pasar los ingredientes del inventario del usuario a la vista
        if (auth()->check()){
            $user = Auth::user();
            if ($user->fk_type == 3) {
                return view('recipes.recipe', compact('preparations', 'recipe', 'isFavorite', 'comments', 'ingredientInventories' , 'percentage'));
            }else {
                return view('recipes.recipe', compact('preparations', 'recipe', 'isFavorite', 'comments'));
            }
        }else {
            return view('recipes.recipe', compact('preparations', 'recipe', 'isFavorite', 'comments'));
        }

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        $user = Auth::user();
        $ingredients = Ingredient::orderBy('ingredient', 'asc')->get();
        $units = Unit::orderBy('unit', 'asc')->get();
        $preparations = array_map('trim', explode("@", $recipe->preparation));
        $typerecipes = TypeRecipe::orderBy('type_recipe', 'asc')->get();

        if ($user->fk_type == 1) {
            // Usuario administrador
            return view('crud.admin.crud.recipe', compact('ingredients', 'units', 'preparations', 'typerecipes'))->with('recipe', $recipe);
        } elseif ($user->fk_type == 3) {
            // Otro tipo de usuario, por ejemplo, un editor
            return view('crud.user.crud.recipe', compact('ingredients', 'units', 'preparations', 'typerecipes'))->with('recipe', $recipe);
        } else{
            return view('welcome');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'time' => 'required|integer|min:1|max:1440',
            'description' => 'required|string|max:280',
            'preparation' => 'required|string',
            'ingredients' => 'required|array',
            'category' => 'required|exists:type_recipes,id',
            'photo' => 'nullable|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ];
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El nombre debe tener maximo 255 caracteres.',
            'time.max' => 'El tiempo no puede ser superior a 1440',
            'description.required' => 'Las descripcion de la receta es obligatoria.',
            'description.max' => 'Las descripcion no debe tener maximo 280 caracteres.',
            'preparation.required' => 'Debes agregar al menos un paso.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ruta para almacenar imágenes
        $filePath = base_path('public_html/uploads/recipes');
        //$filePath = public_path('uploads/recipes');

        // Manejo de la foto
        if ($request->hasFile('photo')) {
            $file = $request->file('photo'); // Nombre original de la imagen
            $file_name = $request->name . 'picture.' . $file->getClientOriginalExtension(); // Nuevo nombre de la imagen
            $fullPath = $filePath . '/' . $file_name;

            // Eliminar el archivo existente si existe
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Mover el nuevo archivo
            $file->move($filePath, $file_name);

            // Asignar el nuevo nombre de archivo a la propiedad photo del modelo
            $recipe->photo = $file_name;
        }

        // Actualizar otros campos del modelo
        $recipe->name = $request->name;
        $recipe->time = $request->time;
        $recipe->description = $request->description;
        $recipe->preparation = $request->preparation;
        $recipe->fk_type_recipe = $request->category;

        // Guardar los cambios en la receta
        $recipe->save();

        // Actualizar ingredientes
        $ingredients = $request->input('ingredients', []);
        $formattedIngredients = [];

        foreach ($ingredients as $id => $data) {
            $formattedIngredients[$id] = [
                'quantity' => $data['quantity'],
                'fk_unit' => $data['unit_id'],
            ];
        }

        // Sincronizar ingredientes
        $recipe->ingredients()->sync($formattedIngredients);

        // Mensaje de éxito
        Session::flash('mensaje', 'Edición exitosa');

        // Redirigir a la lista de recetas
        if (Auth::user()->id == 1){
            return redirect()->route('recipes.index')->with('mensaje', 'Edición exitosa');
        }else{
            return redirect()->route('recipes.user')->with('mensaje', 'Edición exitosa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        Session::flash('mensaje', 'Registro Eliminado');
        if (Auth::user()->id == 1){
            return redirect()->route('recipes.index')->with('mensaje', 'Registro Eliminado');
        }else{
            return redirect()->route('recipes.user')->with('mensaje', 'Registro Eliminado');
        }
    }

    public function searchRecipes(Request $request)
    {
        $ingredients = $request->input('ingredients');
        if (!$ingredients) {
            return redirect()->back()->with('error', 'No se han seleccionado ingredientes.');
        }else{
            $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredients) {
                $query->whereIn('fk_ingredient', $ingredients);
            })->get();
            $categories = TypeRecipe::orderBy('type_recipe', 'asc')->get();
            return view('recipes.recipes', compact('categories'))->with('recipes', $recipes);
        }
    }

    public function toggleFavorite(Request $request, $recipeId)
    {
        $user = auth()->user();
        $recipe = Recipe::findOrFail($recipeId);

        // Buscar el registro en la tabla 'lunches'
        $lunch = $user->recipes()->where('fk_recipe', $recipeId)->first();

        if ($lunch) {
            // Verificar si 'times_made' es 0 y se desmarca como favorito
            if ($lunch->pivot->times_made == 0 && $lunch->pivot->is_favorite) {
                // Si se desmarca como favorito y 'times_made' es 0, eliminar el registro
                $user->recipes()->detach($recipeId);
            } else {
                // De lo contrario, solo desmarcar como favorito
                $lunch->pivot->is_favorite = !$lunch->pivot->is_favorite;
                $lunch->pivot->save();
            }
        } else {
            // Si el registro no existe, crear uno nuevo y marcar como favorito
            $user->recipes()->attach($recipeId, ['is_favorite' => true]);
        }

        return redirect()->back();
    }

    public function recipesUser(){
        $user = Auth::user();
        $recipes = Recipe::orderBy('name', 'asc')->where('fk_creator_recipe', $user->id)->with('ingredients.unit')->paginate(7); // Devuelve en grupos de 7 las recetas

        if ($user != null || $user->fk_type != 3) { // Validación de si hay o no un usuario autenticado
            if ($user->fk_type == 3) { // Usuario administrador
                return view('crud.user.list.recipe')->with('recipes', $recipes);
            }
        } else {
            return view('recipes.recipes')->with('recipes', $recipes);
        }
    }

    private function decimalToFraction($decimal)
    {
        // Si el número es entero, simplemente devuélvelo como "n/1"
        if (fmod($decimal, 1) == 0) {
            return (int)$decimal;
        }

        // Establecer un límite para la precisión
        $precision = 1000000;

        // Multiplicar el decimal para eliminar la parte fraccionaria
        $numerator = round($decimal * $precision);
        $denominator = $precision;

        // Usamos la versión manual de gcd
        $gcd = $this->gcd($numerator, $denominator);

        // Simplificamos la fracción dividiendo por el GCD
        $numerator = $numerator / $gcd;
        $denominator = $denominator / $gcd;

        // Retornamos la fracción simplificada
        return $numerator . '/' . $denominator;
    }

    private function gcd($a, $b)
    {
        // Función para calcular el Máximo Común Divisor (GCD)
        return ($b == 0) ? $a : $this->gcd($b, $a % $b);
    }

    public function recipeChartData()
    {
        // Obtener la cantidad de recetas por tipo
        $recipesByType = Recipe::select('fk_type_recipe', \DB::raw('count(*) as count'))
            ->groupBy('fk_type_recipe')
            ->get();

        // Obtener los nombres de los tipos de receta
        $recipeTypes = TypeRecipe::whereIn('id', $recipesByType->pluck('fk_type_recipe'))->pluck('type_recipe', 'id');

        // Preparar los datos para la gráfica
        $data = [];
        foreach ($recipesByType as $recipe) {
            $data[] = [
                'type' => $recipeTypes[$recipe->fk_type_recipe], // Nombre del tipo de receta
                'count' => $recipe->count, // Cantidad de recetas de ese tipo
            ];
        }

        return response()->json($data);
    }
}
