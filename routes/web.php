<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;


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
    return redirect()->route('home');
});

Route::get('/register', [UserController::class, 'register'])->name('register');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [SupportTicketController::class, 'index'])->name('home');

    Route::get('/tickets', [SupportTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [SupportTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [SupportTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [SupportTicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{id}/edit', [SupportTicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [SupportTicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [SupportTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{supportTicket}/assign', [SupportTicketController::class, 'assign'])->name('tickets.assign');
    Route::post('/tickets/{supportTicket}/reassign', [SupportTicketController::class, 'reassign'])->name('tickets.reassign');
    
    // Only allow users with the "admin" role to access dboard
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/users/{user}/roles', [AdminController::class, 'updateRoles'])->name('admin.users.roles.update');
        Route::resource('admin/roles', RoleController::class);

    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
