<?php

use App\Http\Controllers\Front\FrontLoginController;
use App\Http\Controllers\Front\FrontRegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FuelStationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleRegistrationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FuelRequestController;
use App\Http\Controllers\FuelTokenController;
use App\Http\Controllers\Front\FrontHomeController;

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

Auth::routes();

//Front Routes
Route::prefix('')->middleware('frontRoleCheck')->group(function () {
    Route::get('/home', [FrontHomeController::class, 'index'])->name('front.home');
    Route::get('/', [FrontHomeController::class, 'index'])->name('front.home');


    Route::prefix('front')->group(function () {
        Route::get('/login', [FrontLoginController::class, 'index'])->name('front.login');
        Route::post('/login', [FrontLoginController::class, 'loginUser'])->name('front.login.auth');

        Route::get('/register', [FrontRegisterController::class, 'index'])->name('front.register');
        Route::post('/register', [FrontRegisterController::class, 'registerUser'])->name('front.register.create');

        Route::prefix('home')->group(function () {
            Route::get('/', [FrontHomeController::class, 'index'])->name('front.home.index');
        });
        Route::prefix('vehicle')->group(function () {
            Route::get('/create', [FrontHomeController::class, 'vehicleCreate'])->name('front.vehicle.create');
            Route::get('/', [FrontHomeController::class, 'vehicleShow'])->name('front.vehicle.index');
        });
    });
});

//Admin And Common Routes
Route::prefix('')->middleware('adminRoleCheck')->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/home', [HomeController::class, 'index'])->name('home');
});

Route::prefix('user')->group(function () {
    Route::post('create', [UserController::class, 'create'])->name('user.create');
    Route::post('edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::prefix('customer')->group(function () {
        Route::get('/', [UserController::class, 'customer'])->name('customer.index');
    });
    Route::prefix('manager')->group(function () {
        Route::get('/', [UserController::class, 'manager'])->name('manager.index');
    });

});

Route::prefix('fuelstation')->group(function () {
    Route::get('/', [FuelStationController::class, 'index'])->name('fuelstation.index');
    Route::post('create', [FuelStationController::class, 'create'])->name('fuelstation.create');
    Route::post('edit', [FuelStationController::class, 'edit'])->name('fuelstation.edit');
    Route::put('update/{id}', [FuelStationController::class, 'update'])->name('fuelstation.update');
    Route::delete('delete/{id}', [FuelStationController::class, 'delete'])->name('fuelstation.delete');
});

Route::prefix('vehiclemanagement')->group(function () {
    Route::prefix('vehicle')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::post('create', [VehicleController::class, 'create'])->name('vehicle.create');
        Route::post('edit', [VehicleController::class, 'edit'])->name('vehicle.edit');
        Route::put('update/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
        Route::delete('delete/{id}', [VehicleController::class, 'delete'])->name('vehicle.delete');
    });
    Route::prefix('vehicleregistration')->group(function () {
        Route::get('/', [VehicleRegistrationController::class, 'index'])->name('vehicleregistration.index');
        Route::post('create', [VehicleRegistrationController::class, 'create'])->name('vehicleregistration.create');
        Route::post('edit', [VehicleRegistrationController::class, 'edit'])->name('vehicleregistration.edit');
        Route::put('update/{id}', [VehicleRegistrationController::class, 'update'])->name('vehicleregistration.update');
        Route::delete('delete/{id}', [VehicleRegistrationController::class, 'delete'])->name('vehicleregistration.delete');
    });
});


Route::prefix('schedule')->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('update/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('delete/{id}', [ScheduleController::class, 'delete'])->name('schedule.delete');
    Route::post('status', [ScheduleController::class, 'changeStatus'])->name('schedule.status');
});

Route::prefix('vehicleregister')->group(function () {
    Route::get('/', [VehicleRegistrationController::class, 'index'])->name('vehicleregister.index');
    Route::post('create', [VehicleRegistrationController::class, 'create'])->name('vehicleregister.create');
    Route::post('edit', [VehicleRegistrationController::class, 'edit'])->name('vehicleregister.edit');
    Route::put('update/{id}', [VehicleRegistrationController::class, 'update'])->name('vehicleregister.update');
    Route::delete('delete/{id}', [VehicleRegistrationController::class, 'delete'])->name('vehicleregister.delete');
});

Route::prefix('fuelrequest')->group(function () {
    Route::get('/', [FuelRequestController::class, 'index'])->name('fuelrequest.index');
    Route::post('create', [FuelRequestController::class, 'create'])->name('fuelrequest.create');
    Route::post('edit', [FuelRequestController::class, 'edit'])->name('fuelrequest.edit');
    Route::put('update/{id}', [FuelRequestController::class, 'update'])->name('fuelrequest.update');
    Route::delete('delete/{id}', [FuelRequestController::class, 'delete'])->name('fuelrequest.delete');
    Route::post('status', [FuelRequestController::class, 'changeStatus'])->name('fuelrequest.status');

});

Route::prefix('fueltoken')->group(function () {
    Route::get('/', [FuelTokenController::class, 'index'])->name('fueltoken.index');
    Route::post('create', [FuelTokenController::class, 'create'])->name('fueltoken.create');
    Route::post('edit', [FuelTokenController::class, 'edit'])->name('fueltoken.edit');
    Route::put('update/{id}', [FuelTokenController::class, 'update'])->name('fueltoken.update');
    Route::delete('delete/{id}', [FuelTokenController::class, 'delete'])->name('fueltoken.delete');
    Route::post('status', [FuelTokenController::class, 'changeStatus'])->name('fueltoken.status');
});

Route::prefix('payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('edit', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::put('update/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::delete('delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
});

// Route::prefix('district')->group(function () {
//     Route::get('/', [DistrictController::class, 'index'])->name('district.index');
//     Route::post('create', [DistrictController::class, 'create'])->name('district.create');
//     Route::post('edit', [DistrictController::class, 'edit'])->name('district.edit');
//     Route::put('update/{id}', [DistrictController::class, 'update'])->name('district.update');
//     Route::delete('delete/{id}', [DistrictController::class, 'delete'])->name('district.delete');
// });




