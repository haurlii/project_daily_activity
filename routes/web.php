<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DashboardController;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('showLogin');
        Route::post('/login', 'login')->name('login');
    });
});
Route::middleware('auth')->group(function () {
    Route::middleware('role:SuperAdmin')->prefix('/admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.indexAdmin');

        // User
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('admin.users.index');
            // Route::get('/users/{user:id}', 'show')->name('admin.users.show');
            Route::get('/users/excel', 'excel')->name('admin.users.excel');
            Route::get('/users/pdf', 'pdf')->name('admin.users.pdf');
        });

        // Task
        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasks', 'index')->name('admin.tasks.index');
            // Route::get('/tasks/{task:id}', 'show')->name('admin.tasks.show');
            Route::get('/tasks/excel', 'excel')->name('admin.tasks.excel');
            Route::get('/tasks/pdf', 'pdf')->name('admin.tasks.pdf');
        });

        // Activity
        Route::controller(ActivityController::class)->group(function () {
            Route::get('/activities', 'index')->name('admin.activities.index');
            // Route::get('/activities/{activity:id}', 'show')->name('admin.activities.show');
            Route::get('/activities/excel', 'excel')->name('admin.activities.excel');
            Route::get('/activities/pdf', 'pdf')->name('admin.activities.pdf');
        });
    });

    Route::middleware('role:Leader')->prefix('/leader')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexLeader'])->name('leader.indexLeader');

        // User Management
        Route::controller(UserController::class)->group(function () {
            // index
            Route::get('/users', 'index')->name('leader.users.index');

            // create & store
            Route::get('/users/create', 'create')->name('leader.users.create');
            Route::post('/users/create', 'store')->name('leader.users.store');

            // edit & update
            Route::get('/users/edit/{user:id}', 'edit')->name('leader.users.edit');
            Route::patch('/users/edit/{user:id}', 'update')->name('leader.users.update');

            // delete
            Route::delete('/users/{user:id}', 'destroy')->name('leader.users.destroy');

            // Export
            Route::get('/users/excel', 'excel')->name('leader.users.excel');
            Route::get('/users/pdf', 'pdf')->name('leader.users.pdf');
        });

        Route::controller(TaskController::class)->group(function () {
            // index
            Route::get('/tasks', 'index')->name('leader.tasks.index');

            // create & store
            Route::get('/tasks/create', 'create')->name('leader.tasks.create');
            Route::post('/tasks/create', 'store')->name('leader.tasks.store');

            // Export
            Route::get('/tasks/excel', 'excel')->name('leader.tasks.excel');
            Route::get('/tasks/pdf', 'pdf')->name('leader.tasks.pdf');

            // edit & update
            Route::get('/tasks/edit/{task:id}', 'edit')->name('leader.tasks.edit');
            Route::patch('/tasks/edit/{task:id}', 'update')->name('leader.tasks.update');

            // show
            Route::get('/tasks/{task:id}', 'show')->name('leader.tasks.show');

            // delete
            Route::delete('/tasks/{task:id}', 'destroy')->name('leader.tasks.destroy');
        });

        Route::controller(ActivityController::class)->group(function () {
            // index
            Route::get('/activities', 'index')->name('leader.activities.index');

            // Export
            Route::get('/activities/excel', 'excel')->name('leader.activities.excel');
            Route::get('/activities/pdf', 'pdf')->name('leader.activities.pdf');

            // show
            Route::get('/activities/{activity:id}', 'show')->name('leader.activities.show');
        });
    });

    Route::middleware('role:Member')->prefix('/member')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexMember'])->name('member.indexMember');

        // Task
        Route::controller(TaskController::class)->group(function () {
            // index
            Route::get('/tasks', 'index')->name('member.tasks.index');

            // Export
            Route::get('/tasks/excel', 'excel')->name('member.tasks.excel');
            Route::get('/tasks/pdf', 'pdf')->name('member.tasks.pdf');

            // Export
            Route::get('/tasks/{task:id}', 'show')->name('member.tasks.show');
        });

        // Activity
        Route::controller(ActivityController::class)->group(function () {
            // index
            Route::get('/activities', 'index')->name('member.activities.index');

            // create & store
            Route::get('/activities/create', 'create')->name('member.activities.create');
            Route::post('/activities/create', 'store')->name('member.activities.store');

            // Export
            Route::get('/activities/excel', 'excel')->name('member.activities.excel');
            Route::get('/activities/pdf', 'pdf')->name('member.activities.pdf');

            // edit & update
            Route::get('/activities/edit/{activity:id}', 'edit')->name('member.activities.edit');
            Route::patch('/activities/edit/{activity:id}', 'update')->name('member.activities.update');

            // show
            Route::get('/activities/{activity:id}', 'show')->name('member.activities.show');

            // delete
            Route::delete('/activities/{activity:id}', 'destroy')->name('member.activities.destroy');
        });
    });

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
