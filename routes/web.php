<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReportExportController;

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

Route::get('/', fn() => view('welcome'));

/**
 * Fallback akses file upload pada disk "public".
 *
 * Normalnya Laravel butuh `php artisan storage:link` agar /storage menunjuk ke storage/app/public.
 * Pada beberapa lingkungan (hosting/kampus) symlink kadang tidak tersedia, sehingga gambar tidak tampil.
 * Route ini memastikan /storage/{path} tetap bisa diakses.
 */
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/'.$path);
    abort_unless(is_file($fullPath), 404);
    return response()->file($fullPath);
})->where('path', '.*')->middleware('auth');

Route::middleware(['auth','verified'])->get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('dashboard');

Route::prefix('user')->name('user.')->middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/reports/create', [UserReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [UserReportController::class, 'store'])->name('reports.store');

    Route::get('/reports', [UserReportController::class, 'index'])->name('reports.index');

    Route::get('/reports/{report}', [UserReportController::class, 'show'])->name('reports.show');

    Route::get('/ringkasan', [UserDashboardController::class, 'summary'])->name('summary');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/respond', [AdminReportController::class, 'respond'])->name('reports.respond');
    Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.updateStatus');

    Route::get('/laporan-terbaru', [AdminDashboardController::class, 'laporanTerbaru'])
        ->name('laporan-terbaru');

    Route::get('/reports/export/csv', [ReportExportController::class, 'csv'])
        ->name('reports.export.csv');
});

require __DIR__.'/auth.php';