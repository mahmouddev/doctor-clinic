<?php

use App\Http\Controllers\InstallerController;
use Illuminate\Support\Facades\Route;

Route::get('/install',                [InstallerController::class, 'index'])->name('install');
// json
Route::get('/server-components',      [InstallerController::class, 'serverComponents'])->name('server-components');
// json
Route::get('/directory-permissions',  [InstallerController::class, 'directoryPermissions'])->name('directory-permissions');
Route::post('/check-db-connection',   [InstallerController::class, 'checkDbConnection'])->name('check-db-connection');
Route::post('/complete-installation', [InstallerController::class, 'completeInstallation'])->name('complete-installation');
