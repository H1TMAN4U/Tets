<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/check',[UserController::class,'check']); // add later dasboard view and remove unnesesary route

// Route::get('show',[RecipesController::class,'guest_recipes'], function () {
//     return view('show');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/show', function () {
//     return view('recipes.guest-recipes.show');
// })->middleware(['auth', 'verified'])->name('show');
Route::get('show',[RecipesController::class,'guest_recipes'], function () {
    return view('show');
});


Route::get('/show-full/{id}',[RecipesController::class,'IDrecipe']);
// Route::get('/search',[RecipesController::class,'search']);

// // Route::get('/admin', function () {
// //     return view('admin.index');
// // })->middleware(['auth', 'role:admin'])->name('admin.index');

// Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
//     Route::get('/',[IndexController::class,'index'])->name('index');
//     Route::resource('/roles', RoleController::class);
//     Route::resource('/permissions', PermissionController::class);
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/recipes', RecipesController::class);


});
Route::middleware(['auth', 'role:Admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    // Route::get('/show', [RecipesController::class, 'guest_recipes'])->name('show');
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

});
Route::middleware(['auth', 'role:User'])->name('user.')->prefix('user')->group(function () {
    // Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::resource('/recipes', RecipesController::class);
});
require __DIR__.'/auth.php';
Route::get('/search',[IndexController::class,'search']);
// Route::get('/search',[RecipesController::class,'search']);
