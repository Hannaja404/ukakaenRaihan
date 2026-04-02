<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ResponseController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('student.dashboard');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Student Routes
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
        Route::post('/student/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::put('/admin/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
        Route::post('/admin/complaints/delete/{id}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
        Route::post('/admin/responses', [ResponseController::class, 'store'])->name('responses.store');
        Route::post('/admin/responses/delete/{id}', [ResponseController::class, 'destroy'])->name('responses.destroy');

        // Admin only route
        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/report', [ComplaintController::class, 'report'])->name('admin.report');
        });
    });
});
