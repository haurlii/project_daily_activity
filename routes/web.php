<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
            Route::get('/users', 'indexSuperAdmin')->name('admin.users.index');
            // Route::get('/users/{user:id}', 'show')->name('admin.users.show');
            Route::get('/users/excel', 'excelSuperAdmin')->name('admin.users.excel');
            Route::get('/users/pdf', 'pdfSuperAdmin')->name('admin.users.pdf');
        });

        // Task
        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasks', 'indexSuperAdmin')->name('admin.tasks.index');
            // Route::get('/tasks/{task:id}', 'show')->name('admin.tasks.show');
            Route::get('/tasks/excel', 'excelSuperAdmin')->name('admin.tasks.excel');
            Route::get('/tasks/pdf', 'pdfSuperAdmin')->name('admin.tasks.pdf');
        });

        // Activity
        Route::controller(ActivityController::class)->group(function () {
            Route::get('/activities', 'indexSuperAdmin')->name('admin.activities.index');
            // Route::get('/activities/{activity:id}', 'show')->name('admin.activities.show');
            Route::get('/activities/excel', 'excelSuperAdmin')->name('admin.activities.excel');
            Route::get('/activities/pdf', 'pdfSuperAdmin')->name('admin.activities.pdf');
        });
    });

    Route::middleware('role:Leader')->prefix('/leader')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexLeader'])->name('leader.indexLeader');

        // User Management
        Route::controller(UserController::class)->group(function () {
            // index
            Route::get('/users', 'indexLeader')->name('leader.users.index');

            // create & store
            Route::get('/users/create', 'createLeader')->name('leader.users.create');
            Route::post('/users/create', 'storeLeader')->name('leader.users.store');

            // edit & update
            Route::get('/users/edit/{user:id}', 'editLeader')->name('leader.users.edit');
            Route::patch('/users/edit/{user:id}', 'updateLeader')->name('leader.users.update');

            // delete
            Route::delete('/users/{user:id}', 'destroyLeader')->name('leader.users.destroy');

            // Export
            Route::get('/users/excel', 'excelLeader')->name('leader.users.excel');
            Route::get('/users/pdf', 'pdfLeader')->name('leader.users.pdf');
        });

        Route::controller(TaskController::class)->group(function () {
            // index
            Route::get('/tasks', 'indexLeader')->name('leader.tasks.index');

            // create & store
            Route::get('/tasks/create', 'createLeader')->name('leader.tasks.create');
            Route::post('/tasks/create', 'storeLeader')->name('leader.tasks.store');

            // Export
            Route::get('/tasks/excel', 'excelLeader')->name('leader.tasks.excel');
            Route::get('/tasks/pdf', 'pdf')->name('leader.tasks.pdf');

            // edit & update
            Route::get('/tasks/edit/{task:id}', 'editLeader')->name('leader.tasks.edit');
            Route::patch('/tasks/edit/{task:id}', 'updateLeader')->name('leader.tasks.update');

            // show
            Route::get('/tasks/{task:id}', 'showLeader')->name('leader.tasks.show');

            // delete
            Route::delete('/tasks/{task:id}', 'destroyLeader')->name('leader.tasks.destroy');
        });

        Route::controller(ActivityController::class)->group(function () {
            // index
            Route::get('/activities', 'indexLeader')->name('leader.activities.index');

            // Export
            Route::get('/activities/excel', 'excelLeader')->name('leader.activities.excel');
            Route::get('/activities/pdf', 'pdfLeader')->name('leader.activities.pdf');

            // show
            Route::get('/activities/{activity:id}', 'showLeader')->name('leader.activities.show');
        });
    });

    Route::middleware('role:Member')->prefix('/member')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexMember'])->name('member.indexMember');

        // Task
        Route::controller(TaskController::class)->group(function () {
            // index
            Route::get('/tasks', 'indexMember')->name('member.tasks.index');

            // Export
            Route::get('/tasks/excel', 'excelMember')->name('member.tasks.excel');
            Route::get('/tasks/pdf', 'pdfMember')->name('member.tasks.pdf');

            Route::post('/tasks/{task:id}/start', 'startActivity')->name('member.tasks.startActivity');
            Route::patch('/tasks/{task:id}/continue', 'continueActivity')->name('member.tasks.continueActivity');
            Route::patch('/tasks/{task:id}/end', 'endActivity')->name('member.tasks.endActivity');

            // Export
            Route::get('/tasks/{task:id}', 'showMember')->name('member.tasks.show');
        });

        // Activity
        Route::controller(ActivityController::class)->group(function () {
            // index
            Route::get('/activities', 'indexMember')->name('member.activities.index');

            // create & store
            Route::get('/activities/create', 'createMember')->name('member.activities.create');
            Route::post('/activities/create', 'storeMember')->name('member.activities.store');

            // Export
            Route::get('/activities/excel', 'excelMember')->name('member.activities.excel');
            Route::get('/activities/pdf', 'pdfMember')->name('member.activities.pdf');
            // show
            Route::get('/activities/{activity:id}', 'showMember')->name('member.activities.show');

            // delete
            Route::delete('/activities/{activity:id}', 'destroyMember')->name('member.activities.destroy');

            // edit & update
            Route::get('/activities/edit/{activity:id}', 'editMember')->name('member.activities.edit');
            Route::patch('/activities/edit/{activity:id}', 'updateMember')->name('member.activities.update');

            Route::post('/activities/{activity:id}/start', 'startActivity')->name('member.activities.startActivity');
            Route::patch('/activities/{activity:id}/continue', 'continueActivity')->name('member.activities.continueActivity');
            Route::patch('/activities/{activity:id}/end', 'endActivity')->name('member.activities.endActivity');
        });
    });

    Route::get('/', function () {
        return view('home');
    })->name('home');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
