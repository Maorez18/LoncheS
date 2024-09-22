<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientInventoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\NoCacheMiddleware;
use Illuminate\Support\Facades\Route;

//index
Route::get('/', function () {
    return view('welcome');
});
// Rutas login y logout
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Rutas registro de usuario
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
// Rutas de verificacion de correo
Route::get('verify', [VerificationController::class, 'showVerificationForm'])->name('verification.notice');
Route::post('verify', [VerificationController::class, 'verify'])->name('verification.verify');
// Rutas de administrador
Route::middleware(['auth', CheckAdmin::class, NoCacheMiddleware::class])->group(function () {
    Route::resource('admin/ingredients', IngredientController::class);
    Route::resource('admin/recipes', RecipeController::class);
    Route::resource('admin/users', UserController::class);
    route::get('/api/user-types', [UserController::class, 'getTypeUsers'])->name('users.getData');
    route::get('/api/registrations', [UserController::class, 'getRegistrationData'])->name('users.getRegistrationData');
    route::get('/api/recipe-types', [RecipeController::class, 'recipeChartData'])->name('recipes.recipeChartData');
    Route::get('/admin', function () {
        return view('admin.admin');
    })->name('admin');
});
//Rutas usuario
Route::middleware(['auth', NoCacheMiddleware::class])->group(function(){
    Route::resource('profile/user', UserController::class);
    Route::resource('user/inventory', InventoryController::class);
    Route::resource('user/ingredient', IngredientController::class);
    Route::resource('user/recipe', RecipeController::class);
    Route::delete('/user/inventory/ingredient/{id}', [InventoryController::class, 'destroyIngredient'])->name('inventory.destroyIngredient');
    Route::get('/user/recipe', [RecipeController::class, 'recipesUser'])->name('recipes.user');
    Route::get('/profile', function(){
        return view('user.profile');
    })->name('profile');
});
//ruta busqueda de ingredientes
Route::get('/ingredients/search', [IngredientController::class, 'search'])->name('ingredients.search');
//Ruta receta especifica
Route::get('recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::post('recipes/search', [RecipeController::class, 'searchRecipes'])->name('recipes.search');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
//Rutas reset password
Route::get('password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('password/reset/{email}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
//Ruta receta favorita
Route::post('/recipes/{recipe}/favorite', [RecipeController::class, 'toggleFavorite'])
    ->middleware('auth')
    ->name('recipes.toggleFavorite');
Route::post('/comments/{recipe}', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

