<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ExpenseController;

Route::post('/login', [UserController::class, 'loginUser']);
Route::middleware(['passport-verify'])->get('/isLogin', [UserController::class, 'isLoginUser']);

Route::middleware(['passport-verify', 'admin.middleware'])->prefix('/admin')->group(function (){
    Route::prefix('/auth')->group(function (){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/logout', [UserController::class, 'logoutUser']);
        Route::post('/update/password', [UserController::class, 'UpatePassword']);
    });

    Route::prefix('/role')->group(function (){
        Route::get('/', [RoleController::class, 'show']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/update/{id}', [RoleController::class, 'edit']);
        Route::post('/update/{id}', [RoleController::class, 'update']);
        Route::delete('/delete/{id}', [RoleController::class, 'destroy']);
    });

    Route::prefix('/user')->group(function (){
        Route::get('/', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/update/{id}', [UserController::class, 'edit']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('/category')->group(function (){
        Route::get('/', [CategoryController::class, 'show']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/update/{id}', [CategoryController::class, 'edit']);
        Route::post('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('/expense')->group(function (){
        Route::get('/', [ExpenseController::class, 'showAdminExpenses']);
        Route::get('/total', [ExpenseController::class, 'showAdminExpensesTotal']);
        Route::post('/', [ExpenseController::class, 'store']);
        Route::get('/update/{id}', [ExpenseController::class, 'edit']);
        Route::post('/update/{id}', [ExpenseController::class, 'update']);
        Route::delete('/delete/{id}', [ExpenseController::class, 'destroy']);
    });
});


Route::middleware(['passport-verify', 'user.middleware'])->prefix('/user')->group(function (){
    Route::prefix('/auth')->group(function (){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/logout', [UserController::class, 'logoutUser']);
        Route::post('/update/password', [UserController::class, 'UpatePassword']);
    });
    Route::prefix('/expense')->group(function (){
        Route::get('/', [ExpenseController::class, 'showUserExpenses']);
        Route::get('/total', [ExpenseController::class, 'showUserExpensesTotal']);
        Route::post('/', [ExpenseController::class, 'store']);
        Route::get('/update/{id}', [ExpenseController::class, 'editUserExpense']);
        Route::post('/update/{id}', [ExpenseController::class, 'update']);
        Route::delete('/delete/{id}', [ExpenseController::class, 'destroyUserExpenses']);
    });
    Route::prefix('/category')->group(function (){
        Route::get('/', [CategoryController::class, 'show']);
    });
});

