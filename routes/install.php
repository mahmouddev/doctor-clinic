<?php

use App\Http\Controllers\InstallerController;
use Illuminate\Support\Facades\Route;

Route::get('/install',                [InstallerController::class, 'index'])->name('install');
// json
Route::get('/requirements',           [InstallerController::class, 'requirements'])->name('requirements');
// json
Route::get('/permissions',            [InstallerController::class, 'permissions'])->name('permissions');
Route::post('/test-connection',       [InstallerController::class, 'testDBConnection'])->name('test-connection');
Route::post('/complete-installation', [InstallerController::class, 'completeInstallation'])->name('complete-installation');
