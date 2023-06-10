<?php

use App\Http\Controllers\Backend\Clinic\BackendInvoiceController;
use App\Http\Controllers\Backend\Clinic\BackendPatientController;
use App\Http\Controllers\Backend\Clinic\BackendAppointmentController;
use App\Http\Controllers\Backend\Clinic\BackendPrescriptionController;

Route::prefix('admin')
    ->middleware(['auth'])
    ->name('admin.clinic.')
    ->group(function () {

        Route::post('patients/search/', [BackendPatientController::class, 'search'])->name('get-patients');
        Route::resource('patients', BackendPatientController::class);

        Route::get('appointments/today-appointments', [BackendAppointmentController::class, 'todayAppointments'])->name('appointments.today-appointments');
        Route::resource('appointments', BackendAppointmentController::class);

        //prescriptions
        Route::get('prescriptions/view/{id}', [BackendPrescriptionController::class, 'view'])->name('prescriptions.view');
        Route::resource('prescriptions',       BackendPrescriptionController::class);

        Route::get('invoices',                 [BackendInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/create',          [BackendInvoiceController::class, 'create'])->name('invoices.create');
        Route::get('invoices/view/{id}',       [BackendInvoiceController::class, 'view'])->name('invoices.view');
        Route::post('invoices/store',          [BackendInvoiceController::class, 'store'])->name('invoices.store');
        Route::get('invoices/edit/{id}',       [BackendInvoiceController::class, 'edit'])->name('invoices.edit');
        Route::post('invoices/update/{id}',    [BackendInvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('invoices/destroy/{id}', [BackendInvoiceController::class, 'destroy'])->name('invoices.destroy');

    });
    