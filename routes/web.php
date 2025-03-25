<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Teacher\Student\AddStudent;
use App\Livewire\Teacher\Student\EditStudent;
use App\Livewire\Teacher\Student\StudentList;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'teacher'])
    ->name('teacher.dashboard');

// Students
Route::get('/student-list', StudentList::class)->name('student.index');
Route::get('/create/student', AddStudent::class)->name('student.create');
Route::get('/edit/student/{id}', EditStudent::class)->name('student.edit');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['admin', 'auth'])->group(function () {
    Route::get('/admin/dashboard',AdminDashboard::class)->name('admin.dashboard');
});

require __DIR__.'/auth.php';
