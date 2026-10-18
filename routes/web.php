<?php

use App\Http\Controllers\Admin\AlertController as AdminAlertController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GarageController as AdminGarageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\App\AlertController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\MapController;
use App\Http\Controllers\App\PlanController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\ServiceRequestController;
use App\Http\Controllers\App\VehicleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/logo', 'pages.logo')->name('logo');
Route::view('/privacidade', 'pages.privacy')->name('privacy');
Route::view('/termos', 'pages.terms')->name('terms');
Route::get('/theme', [ThemeController::class, 'toggle'])->name('theme');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('app')->name('app.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::patch('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');

    Route::get('/services', [ServiceRequestController::class, 'index'])->name('services.index');
    Route::get('/services/new', [ServiceRequestController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceRequestController::class, 'store'])->name('services.store');
    Route::patch('/services/{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel'])->name('services.cancel');

    Route::get('/map', [MapController::class, 'index'])->name('map');
    Route::get('/plans', [PlanController::class, 'index'])->name('plans');
    Route::post('/plans', [PlanController::class, 'subscribe'])->name('plans.subscribe');

    Route::get('/notifications', [AlertController::class, 'index'])->name('alerts');
    Route::patch('/notifications/{alert}/read', [AlertController::class, 'read'])->name('alerts.read');
    Route::post('/notifications/read-all', [AlertController::class, 'readAll'])->name('alerts.read-all');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::get('/vehicles', [AdminVehicleController::class, 'index'])->name('vehicles');
    Route::get('/services', [AdminServiceRequestController::class, 'index'])->name('services');
    Route::patch('/services/{serviceRequest}', [AdminServiceRequestController::class, 'update'])->name('services.update');
    Route::get('/garages', [AdminGarageController::class, 'index'])->name('garages');
    Route::post('/garages', [AdminGarageController::class, 'store'])->name('garages.store');
    Route::delete('/garages/{garage}', [AdminGarageController::class, 'destroy'])->name('garages.destroy');
    Route::get('/plans', [AdminPlanController::class, 'index'])->name('plans');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/notifications', [AdminAlertController::class, 'index'])->name('alerts');
    Route::post('/notifications', [AdminAlertController::class, 'store'])->name('alerts.store');
});
