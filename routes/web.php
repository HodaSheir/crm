<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
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


// Admin routes
// Public admin routes (login)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
});

// Protected admin routes (require admin auth)
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/assign-customer/{customerId}', [AdminController::class, 'assignCustomerToEmployee'])->name('admin.assign.customer');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::resource('employees', EmployeeController::class);
});

// Employee routes
// Public employee routes (login)
Route::prefix('employee')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeLoginController::class, 'login'])->name('employee.login.submit');
});

// Protected employee routes (require employee auth)
Route::prefix('employee')->middleware('auth:employee')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::post('/add-action/{customerId}', [EmployeeController::class, 'addAction'])->name('employee.add.action');
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');
    Route::put('/actions/{action}', [ActionController::class, 'update'])->name('actions.update');
});

// Customer routes (accessible by both admins and employees)
Route::middleware('auth:admin,employee')->group(function () {
    Route::resource('customers', CustomerController::class);
});