<?php
# Backend Controllers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Backend\BackendFileController;
use App\Http\Controllers\Backend\BackendRoleController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendHelperController;
use App\Http\Controllers\Backend\BackendProfileController;
use App\Http\Controllers\Backend\BackendSettingController;


# Frontend Controllers


Auth::routes();

Route::get('/', [FrontController::class, 'index'])->name('home');

Route::prefix('admin')
    ->middleware(['auth', 'ActiveAccount'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', [BackendAdminController::class, 'index'])->name('index');
        Route::resource('files', BackendFileController::class);
        Route::resource('users', BackendUserController::class);
        Route::resource('roles', BackendRoleController::class);
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [BackendSettingController::class, 'index'])->name('index');
            Route::put('/update', [BackendSettingController::class, 'update'])->name('update');
        });


        Route::prefix('upload')->name('upload.')->group(function () {
            Route::post('/image', [BackendHelperController::class, 'uploadImage'])->name('image');
            Route::post('/file', [BackendHelperController::class, 'uploadFile'])->name('file');
            Route::post('/remove-file', [BackendHelperController::class, 'removeFiles'])->name('remove-file');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [BackendProfileController::class, 'index'])->name('index');
            Route::get('/edit', [BackendProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [BackendProfileController::class, 'update'])->name('update');
            Route::put('/update-password', [BackendProfileController::class, 'updatePassword'])->name('update-password');
            Route::put('/update-email', [BackendProfileController::class, 'updateEmail'])->name('update-email');
        });

    });

Route::get('robots.txt', [BackendHelperController::class, 'robots']);
Route::get('manifest.json', [BackendHelperController::class, 'manifest'])->name('manifest');

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

foreach (glob(__DIR__."/apps/*.php") as $appRoutes)
{
    include $appRoutes;
}