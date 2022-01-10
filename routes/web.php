<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\LandingPageController;
use App\Http\Controllers\Front\NoteController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\ScheduleController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\WebProfileController;
use App\Http\Controllers\Back\AdminProfileController;
use App\Http\Controllers\Back\NoteBackController;
use App\Http\Controllers\Back\GalleryBackController;
use App\Http\Controllers\Back\ScheduleBackController;
use App\Http\Controllers\Back\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', LandingPageController::class);
Route::resource('note', NoteController::class);
Route::resource('gallery', GalleryController::class);
Route::resource('schedule', ScheduleController::class);
Route::resource('outer', OuterFrontController::class);
Route::resource('dashboard', DashboardController::class);
Route::resource('login', AuthController::class)->middleware('guest');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('admin-profile', AdminProfileController::class);
    Route::post('admin-profile/check-username', [AdminProfileController::class, 'checkUsername'])->name('checkUsername');
    Route::post('admin-profile/check-email', [AdminProfileController::class, 'checkEmail'])->name('checkEmail');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('web-profile', WebProfileController::class);
    Route::resource('note-back', NoteBackController::class);
    Route::resource('gallery-back', GalleryBackController::class);
    Route::resource('schedule-back', ScheduleBackController::class);
    Route::post('schedule-day', [ScheduleBackController::class, 'schedule_day_store'])->name('schedule-day.store');
    Route::post('schedule-day/check-hari', [ScheduleBackController::class, 'checkHari'])->name('checkHari');
    Route::put('schedule-day/update/{id}', [ScheduleBackController::class, 'schedule_day_update'])->name('schedule-day.update');
    Route::delete('schedule-day/destroy/{id}', [ScheduleBackController::class, 'schedule_day_destroy'])->name('schedule-day.destroy');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});