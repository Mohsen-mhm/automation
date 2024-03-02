<?php

use App\Livewire\Home;
use App\Livewire\Panel\Alerts\Index as AlertsIndex;
use App\Livewire\Panel\Auth\Admin\Login as AdminLogin;
use App\Livewire\Panel\Auth\Company\Login as CompanyLogin;
use App\Livewire\Panel\Auth\Greenhouse\Login as GreenhouseLogin;
use App\Livewire\Panel\Auth\Organization\Login as OrganizationLogin;
use App\Livewire\Panel\Auth\Company\Register as CompanyRegister;
use App\Livewire\Panel\Auth\Greenhouse\Register as GreenhouseRegister;
use App\Livewire\Panel\Automations\Index as AutomationsIndex;
use App\Livewire\Panel\Companies\Index as CompaniesIndex;
use App\Livewire\Panel\Configs\Index as ConfigsIndex;
use App\Livewire\Panel\Greenhouses\Index as GreenhousesIndex;
use App\Livewire\Panel\Index as MainIndex;
use App\Livewire\Panel\Auth\Organization\Register as OrganizationRegister;
use App\Livewire\Panel\Organizations\Index as OrganizationsIndex;
use App\Livewire\Panel\Permissions\Index as PermissionsIndex;
use App\Livewire\Panel\Profile;
use App\Livewire\Panel\Roles\Index as RolesIndex;
use App\Livewire\Panel\Users\Index as UsersIndex;
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

Route::get('/', MainIndex::class)->name('home');

Route::get('/users', UsersIndex::class)->name('users');
Route::get('/configs', ConfigsIndex::class)->name('configs');
Route::get('/profile', Profile::class)->name('profile');

Route::get('/roles', RolesIndex::class)->name('roles');
Route::get('/permissions', PermissionsIndex::class)->name('permissions');

Route::get('/companies', CompaniesIndex::class)->name('companies');
Route::get('/greenhouses', GreenhousesIndex::class)->name('greenhouses');
Route::get('/organizations', OrganizationsIndex::class)->name('organizations');
Route::get('/automations', AutomationsIndex::class)->name('automations');

Route::get('/alerts', AlertsIndex::class)->name('alerts');
