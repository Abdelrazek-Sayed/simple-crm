<?php

use App\Http\Livewire\Admin\Appointments\UpdateAppointmentForm;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Users\ListUsers;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointments\CreateAppointmentsForm;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Profile\UpdateProfile;

Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('users', ListUsers::class)->name('users');
    Route::get('appointments', ListAppointments::class)->name('appointments');
    Route::get('appointments/create', CreateAppointmentsForm::class)->name('appointments.create');
    Route::get('appointments/{appointment}/edit', UpdateAppointmentForm::class)->name('appointments.edit');
    Route::get('profile', UpdateProfile::class)->name('profile');


 
