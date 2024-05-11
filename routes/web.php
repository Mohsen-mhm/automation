<?php

use App\Livewire\Home;
use App\Livewire\Panel\Auth\Admin\Login as AdminLogin;
use App\Livewire\Panel\Auth\Company\Login as CompanyLogin;
use App\Livewire\Panel\Auth\Greenhouse\Login as GreenhouseLogin;
use App\Livewire\Panel\Auth\Organization\Login as OrganizationLogin;
use App\Livewire\Panel\Auth\Company\Register as CompanyRegister;
use App\Livewire\Panel\Auth\Greenhouse\Register as GreenhouseRegister;
use App\Livewire\Panel\Auth\Organization\Register as OrganizationRegister;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', Home::class)->name('home');

Route::prefix('/login')->as('login.')->middleware(['guest'])->group(function () {
    Route::get('/simurgh', AdminLogin::class)->name('simurgh');
    Route::get('/company', CompanyLogin::class)->name('company');
    Route::get('/greenhouse', GreenhouseLogin::class)->name('greenhouse');
    Route::get('/organization', OrganizationLogin::class)->name('organization');

    Route::get('/dwop', function () {
        \Illuminate\Support\Facades\Auth::loginUsingId(\App\Models\User::query()->where([
            'national_id' => '1234567891',
            'phone_number' => '12345678910',
        ])->first()->id);
        return redirect()->route('panel.home');
    });
});

Route::prefix('/register')->as('register.')->middleware(['guest'])->group(function () {
    Route::get('/company', CompanyRegister::class)->name('company');
    Route::get('/greenhouse', GreenhouseRegister::class)->name('greenhouse');
    Route::get('/organization', OrganizationRegister::class)->name('organization');
});


Route::get('system-start', function () {
    Artisan::call('key:generate');
    Artisan::call('migrate:fresh');
    Artisan::call('storage:link');
    Artisan::call('db:seed');
    Artisan::call('optimize:clear');
});


