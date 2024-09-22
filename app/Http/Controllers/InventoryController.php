<?php

namespace App\Http\Controllers;

use App\Models\IngredientInventory;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el inventario del usuario logueado
        $user = auth()->user();

        if ($user->fk_type == 3){
            // Usar first() para obtener una instancia de Inventory
            $inventory = Inventory::where('fk_user', $user->id)->first();

            if ($inventory){
                // Verificar si el inventario existe antes de intentar obtener los ingredientes
                if ($inventory) {
                    $ingredients = $inventory->ingredients()->withPivot('quantity', 'fk_unit')->get();
                } else {
                    $ingredients = collect(); // Si no hay inventario, pasar una colección vacía
                }
                return view('user.inventory', compact('ingredients', 'inventory'));
            } else{
                $this->createInventory($user);
            }
        }else{
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'ingredient' => 'required|integer',
            'quantity' => ['required', 'string', 'max:10', 'regex:/^\d+(\.\d{1,})?$|^\d+\/\d+$/'],
            'unit' => 'required|integer',
        ];
        $messages = [
            'ingredient.required' => 'El ingrediente es obligatorio.',
            'ingredient.integer' => 'El ID del ingrediente debe ser un numero entero.',
            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.max' => 'La cantidad no debe tener mas de 4 caracteres.',
            'quantity.regex' => 'La cantidad debe ser un número entero, una fracción o un número decimal con un solo punto decimal.',
            'unit.required' => 'El ingrediente es obligatorio.',
            'unit.integer' => 'El ID del ingrediente debe ser un numero entero.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $inventory = Inventory::select('id')->where('fk_user', $user->id)->first();
        // Crear nuevo ingrediente en el inventario
        IngredientInventory::create([
            'quantity' => $request->quantity,
            'fk_ingredient' => $request->ingredient,
            'fk_unit' => $request->unit,
            'fk_inventory' => $inventory->id,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Ingrediente añadido exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $inventory = Inventory::where('fk_user', $user->id)->first();
        $ingredientInventory = IngredientInventory::where('fk_ingredient', $id)->where('fk_inventory', $inventory->id)->first();

        if ($ingredientInventory) {
            $rules = [
                'quantity' => ['required', 'string', 'max:10', 'regex:/^\d+(\.\d{1,})?$|^\d+\/\d+$/'],
                'unit' => 'required|integer',
            ];
            $messages = [
                'quantity.required' => 'El campo cantidad es obligatorio.',
                'quantity.max' => 'La cantidad no debe tener mas de 4 caracteres.',
                'quantity.regex' => 'La cantidad debe ser un número entero, una fracción o un número decimal con un solo punto decimal.',
                'unit.required' => 'El ingrediente es obligatorio.',
                'unit.integer' => 'El ID del ingrediente debe ser un numero entero.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ingredientInventory->quantity = $request->quantity;
            $ingredientInventory->fk_unit = $request->unit;
            $ingredientInventory->save();
        }
        Session::flash('mensaje', 'Edición exitosa');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {

    }

    public function createInventory(User $user){
        Inventory::create([
            'fk_user' => $user->id,
        ]);

        return view('user.inventory');
    }

    public function destroyIngredient($id)
    {
        $user = Auth::user();
        $inventory = Inventory::where('fk_user', $user->id)->first();
        $ingredientInventory = IngredientInventory::where('fk_ingredient', $id)->where('fk_inventory', $inventory->id)->first();
        // Si el registro existe, elimínalo
        if ($ingredientInventory) {
            $ingredientInventory->delete();
            Session::flash('mensaje', 'Registro Eliminado');
            return redirect()->back();
        }
        // Si no se encuentra el registro, retorna un mensaje de error
        return redirect()->back()->with('error', 'Registro no encontrado.');
    }
}
