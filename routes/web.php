<?php

use App\Http\Controllers\Admin\VehicleBrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

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

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files = glob(lang_path($lang.'/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo 'window.i18n = '.json_encode($strings).';';
    exit();
})->name('assets.lang');

Route::get('login', [AuthenticationController::class, 'login'])->name('login');

Route::post('login', [AuthenticationController::class, 'doLogin']);

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('orders', OrderController::class);

    Route::prefix('master')->group(function () {
        Route::get('vehicle-brands', [VehicleBrandController::class, 'index'])->name('master.vehicle-brands');
    });
});

Route::get('/', function() {
    echo 'welcome!';
});
