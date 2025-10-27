<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\CategoryEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\CategoryCreate;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Staff\DashboardStaff;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Livewire\Manager\DashboardManager;
use App\Livewire\Admin\Barangs\BarangIndex;


Route::get('/login', Login::class)->name('login');
Route::prefix('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
});

Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/', DashboardAdmin::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
    Route::get('/categories/edit/{id}', CategoryEdit::class)->name('categories.edit');
    Route::get('/barangs/barang', BarangIndex::class)->name('barangs.list');


});

Route::prefix('manager')->middleware(['auth', ManagerMiddleware::class])->name('manager.')->group(function () {
    Route::get('/', DashboardManager::class)->name('dashboard');
});

Route::prefix('staff')->middleware(['auth', StaffMiddleware::class])->name('staff.')->group(function () {
    Route::get('/', DashboardStaff::class)->name('dashboard');
});



Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

