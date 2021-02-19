<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ImportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Menus

Route::get('menus', [MenusController::class, 'index'])
    ->name('menus')
    ->middleware('remember', 'auth');

Route::get('menus/create', [MenusController::class, 'create'])
    ->name('menus.create')
    ->middleware('auth');

Route::post('menus', [MenusController::class, 'store'])
    ->name('menus.store')
    ->middleware('auth');

Route::get('menus/{menu}/edit', [MenusController::class, 'edit'])
    ->name('menus.edit')
    ->middleware('auth');

Route::put('menus/{menu}', [MenusController::class, 'update'])
    ->name('menus.update')
    ->middleware('auth');

Route::delete('menus/{menu}', [MenusController::class, 'destroy'])
    ->name('menus.destroy')
    ->middleware('auth');

Route::put('menus/{menu}/restore', [MenusController::class, 'restore'])
    ->name('menus.restore')
    ->middleware('auth');

// Recipes



Route::get('recipes', [RecipesController::class, 'index'])
    ->name('recipes')
    ->middleware('remember', 'auth');

Route::get('recipes/create', [RecipesController::class, 'create'])
    ->name('recipes.create')
    ->middleware('auth');

Route::post('recipes', [RecipesController::class, 'store'])
    ->name('recipes.store')
    ->middleware('auth');

Route::get('recipes/{recipe}/edit', [RecipesController::class, 'edit'])
    ->name('recipes.edit')
    ->middleware('auth');

Route::put('recipes/{recipe}', [RecipesController::class, 'update'])
    ->name('recipes.update')
    ->middleware('auth');

Route::delete('recipes/{recipe}', [RecipesController::class, 'destroy'])
    ->name('recipes.destroy')
    ->middleware('auth');

Route::put('recipes/{recipe}/restore', [RecipesController::class, 'restore'])
    ->name('recipes.restore')
    ->middleware('auth');


// Ingredients


Route::get('ingredients', [IngredientsController::class, 'index'])
    ->name('ingredients')
    ->middleware('remember', 'auth');

Route::get('ingredients/create', [IngredientsController::class, 'create'])
    ->name('ingredients.create')
    ->middleware('auth');

Route::post('ingredients', [IngredientsController::class, 'store'])
    ->name('ingredients.store')
    ->middleware('auth');

Route::get('ingredients/{ingredient}/edit', [IngredientsController::class, 'edit'])
    ->name('ingredients.edit')
    ->middleware('auth');

Route::put('ingredients/{ingredient}', [IngredientsController::class, 'update'])
    ->name('ingredients.update')
    ->middleware('auth');

Route::delete('ingredients/{ingredient}', [IngredientsController::class, 'destroy'])
    ->name('ingredients.destroy')
    ->middleware('auth');

Route::put('ingredients/{ingredient}/restore', [IngredientsController::class, 'restore'])
    ->name('ingredients.restore')
    ->middleware('auth');


// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('remember', 'auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

Route::get('import', [ImportsController::class, 'index'])
    ->name('imports')
    ->middleware('auth');

Route::post('import',[IngredientsController::class,'import'])->name('import')->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
