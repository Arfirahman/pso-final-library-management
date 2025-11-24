<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

// Routes for authentication process (login and logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route group that requires basic authentication (AuthMiddleware)
Route::middleware(['auth.basic'])->group(function () {
    // Admin Dashboard & Management Routes (protected by role:admin)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Routes for Book Management
        Route::get('/books', [AdminController::class, 'booksIndex'])->name('books.index');
        Route::get('/books/create', [AdminController::class, 'booksCreate'])->name('books.create');
        Route::post('/books', [AdminController::class, 'booksStore'])->name('books.store');
        Route::get('/books/{book}/edit', [AdminController::class, 'booksEdit'])->name('books.edit');
        Route::put('/books/{book}', [AdminController::class, 'booksUpdate'])->name('books.update');
        Route::delete('/books/{book}', [AdminController::class, 'booksDestroy'])->name('books.destroy');

        // Routes for Borrowing History (Admin View)
        Route::get('/borrows', [AdminController::class, 'borrowsIndex'])->name('borrows.index');
        Route::post('/borrows', [AdminController::class, 'storeBorrow'])->name('borrows.store'); // For recording new borrowing

        // Routes for User Management by Admin
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create'); // Show add user form
        Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');     // Store new user
        
        // NEW: Routes for User List, Edit, Delete
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index'); // User list
        Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit'); // Show edit form
        Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update'); // Update user
        Route::delete('/users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy'); // Delete user
    });

    // User Dashboard Routes (protected by role:user)
    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        // Routes for Book Borrowing
        Route::post('/borrow', [UserController::class, 'storeBorrow'])->name('borrow.store');

        // Route for Borrowing Confirmation Page
        Route::get('/borrow/confirmation', [UserController::class, 'borrowConfirmation'])->name('borrow.confirmation');

        // Routes for User Borrowing History (future)
        // Route::get('/history', [UserController::class, 'history'])->name('history');
    });

    // Default route after login, redirects to dashboard based on role
    Route::get('/', function () {
        $user = \App\Models\User::find(session('user_id'));
        if ($user) {
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }
        return redirect()->route('login');
    })->name('home');
});
