<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Middleware\ManagerMiddleware;

// ===== ADMIN =====
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\CategoryEdit;
use App\Livewire\Admin\CategoryCreate;
use App\Livewire\Admin\Barangs\BarangShow;
use App\Livewire\Admin\Barangs\BarangEdit;
use App\Livewire\Admin\Barangs\BarangCreate;
use App\Livewire\Admin\Barangs\BarangIndex as AdminBarangIndex;
use App\Livewire\Admin\Pengadaans\PengadaanShow;
use App\Livewire\Admin\Pengadaans\PengadaanIndex as AdminPengadaanIndex;
use App\Livewire\Admin\Usermanagement\UserEdit;
use App\Livewire\Admin\Usermanagement\UserIndex;
use App\Livewire\Admin\Usermanagement\UserCreate;
use App\Livewire\Admin\Logs\LogIndex;
use App\Livewire\Admin\Profile\ProfileIndex as AdminProfileIndex;
use App\Livewire\Admin\Profile\ProfileEdit as AdminProfileEdit;

// ===== MANAGER =====
use App\Livewire\Manager\DashboardManager;
use App\Livewire\Manager\Pengadaans\PengadaanIndex as ManagerPengadaanIndex;
use App\Livewire\Manager\Pengadaans\PengadaanShow as ManagerPengadaanShow;
use App\Livewire\Manager\Categories\CategoryIndex as ManagerCategoryIndex;
use App\Livewire\Manager\Barangs\BarangIndex as ManagerBarangIndex;
use App\Livewire\Manager\Barangs\BarangShow as ManagerBarangShow;
use App\Livewire\Manager\UserManagement\UserIndex as ManagerUserIndex;
use App\Livewire\Manager\UserManagement\UserShow as ManagerUserShow;
use App\Livewire\Manager\Profile\ProfileIndex as ManagerProfileIndex;
use App\Livewire\Manager\Profile\ProfileEdit as ManagerProfileEdit;
use App\Livewire\Manager\RiwayatPengadaan\RiwayatPengadaanIndex as ManagerRiwayatPengadaanIndex;
use App\Livewire\Manager\RiwayatPengadaan\RiwayatPengadaanShow as ManagerRiwayatPengadaanShow;

// ===== STAFF =====
use App\Livewire\Staff\DashboardStaff;
use App\Livewire\Staff\Categories\CategoryIndex;
use App\Livewire\Staff\Barangs\BarangIndex as StaffBarangIndex;
use App\Livewire\Staff\Pengadaanitem\PengadaanIndex as StaffPengadaanItemIndex;
use App\Livewire\Staff\Pengadaans\PengadaanIndex as StaffPengadaanIndex;
use App\Livewire\Staff\Pengadaans\PengadaanShow as StaffPengadaanShow;
use App\Livewire\Staff\Profile\ProfileIndex as StaffProfileIndex;
use App\Livewire\Staff\Profile\ProfileEdit as StaffProfileEdit;

Route::get('/', function () {
    return redirect()->route('login');
});

// ===== LOGIN / REGISTER =====
Route::get('/login', Login::class)->name('login');
Route::prefix('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
});

// ========================= ADMIN =========================
Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/', DashboardAdmin::class)->name('dashboard');

    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
    Route::get('/categories/edit/{id}', CategoryEdit::class)->name('categories.edit');

    Route::get('/barangs', AdminBarangIndex::class)->name('barangs.index');
    Route::get('/barangs/create', BarangCreate::class)->name('barangs.create');
    Route::get('/barangs/edit/{id}', BarangEdit::class)->name('barangs.edit');
    Route::get('/barangs/show/{id}', BarangShow::class)->name('barangs.show');

    Route::get('/pengadaans', AdminPengadaanIndex::class)->name('pengadaans.index');
    Route::get('/pengadaans/{id}', PengadaanShow::class)->name('pengadaans.show');

    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/users/edit/{id}', UserEdit::class)->name('users.edit');

    Route::get('/logs', LogIndex::class)->name('logs.index');

    Route::get('/profile', AdminProfileIndex::class)->name('profile.index');
    Route::get('/profile/edit', AdminProfileEdit::class)->name('profile.edit');
});

// ========================= MANAGER =========================
Route::prefix('manager')->middleware(['auth', ManagerMiddleware::class])->name('manager.')->group(function () {
    Route::get('/', DashboardManager::class)->name('dashboard');

    Route::get('/categories', ManagerCategoryIndex::class)->name('categories.index');

    Route::get('/barangs', ManagerBarangIndex::class)->name('barangs.index');
    Route::get('/barangs/show/{id}', ManagerBarangShow::class)->name('barangs.show');

    Route::get('/pengadaans', ManagerPengadaanIndex::class)->name('pengadaans.index');
    Route::get('/pengadaans/{id}', ManagerPengadaanShow::class)->name('pengadaans.show');

    Route::get('/riwayat-pengadaan', ManagerRiwayatPengadaanIndex::class)->name('riwayatpengadaan.index');
    Route::get('/riwayat-pengadaan/{id}', ManagerRiwayatPengadaanShow::class)->name('riwayatpengadaan.show');


    Route::get('/users', ManagerUserIndex::class)->name('users.index');
    Route::get('/users/show/{id}', ManagerUserShow::class)->name('users.show');

    Route::get('/profile', ManagerProfileIndex::class)->name('profile.index');
    Route::get('/profile/edit', ManagerProfileEdit::class)->name('profile.edit');

});

// ========================= STAFF =========================
Route::prefix('staff')->middleware(['auth', StaffMiddleware::class])->name('staff.')->group(function () {
    Route::get('/', DashboardStaff::class)->name('dashboard');

    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/barangs', StaffBarangIndex::class)->name('barangs.index');
    Route::get('/pengadaans', StaffPengadaanIndex::class)->name('pengadaans.index');
    Route::get('/pengadaans/{id}', StaffPengadaanShow::class)->name('pengadaans.show');
    Route::get('/pengadaanitems', StaffPengadaanItemIndex::class)->name('pengadaanitems.index');

    Route::get('/profile', StaffProfileIndex::class)->name('profile.index');
    Route::get('/profile/edit', StaffProfileEdit::class)->name('profile.edit');
});

// ========================= LOGOUT =========================
Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
