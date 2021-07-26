<?php
/** 
 * Livewire User Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Route::get('/', 'SiteController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','verified','role:superadministrator|administrator'])
    ->name('admin.')->prefix('/admin')->group( 
        function () {
            //Route::get('/users', [Users::class,'render'])->name('users');
            Route::get('/users', 'User\UserController@index')->name('users');
            Route::get('/users/{user}', 'User\UserController@show')
                ->middleware('permission:users-read')->name('users.show');
            Route::delete('/users/{user}', 'User\UserController@destroy')
                ->middleware('permission:users-delete')->name('users.destroy');
            Route::namespace('Admin')->group(
                function () {
                    Route::get('/roles', 'RoleController@index')
                        ->name('role');
                }
            );
            Route::get('/clients', 'Management\RealStateController@index')
                ->name('clients')->middleware('permission:allCompanies-read');
        }
    );
Route::patch('admin/users/{id}/changeStatus', 'User\UserController@changeStatus')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.changeStatus');
Route::post('admin/users/{id}/permissions', 'User\UserController@getPermissions')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.permissions.list');
Route::post('admin/users/{id}/roles', 'User\UserController@getRoles')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.roles.list');
Route::post('admin/users/{id}/fillroleprofiles', 'User\UserController@fillRolesProfiles')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.rolesprofiles.fill');
Route::patch('admin/users/{id}/update-roles-permissions', 'User\UserController@updateRolesPermissions')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.rolesprofiles.update');

Route::get('/users/{user:id}/profile', 'User\UserController@profile')
    ->middleware(['auth', 'verified'])->name('user.profile');

Route::get('/company/{company:slug}/profile', 'Management\RealStateController@profile')
    ->middleware(['auth', 'verified', 'belong.company','permission:company-read'])
    ->name('company.profile');
    
Route::get('/company/{company:slug}/apartments-setting', 'Management\ApartmentTypeController@index')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.apartment-setting');
Route::post('/company/{company:slug}/apartments-setting', 'Management\ApartmentTypeController@store')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.apartment-setting.store');
Route::post('/company/{id}/apartments-setting/{apartTypeId}/edit', 'Management\ApartmentTypeController@edit')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.apartment-setting.edit');
Route::delete('/company/{id}/apartments-setting/{apartTypeId}', 'Management\ApartmentTypeController@destroy')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.apartment-setting.destroy');

Route::get('/company/{company:slug}/furnitures-setting', 'Management\FurnitureTypeController@index')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.furniture-setting');
Route::post('/company/{company:slug}/furniture-setting', 'Management\FurnitureTypeController@store')
    ->middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.furniture-setting.store');
    
Route::get('/company/{company:slug}/employees', 'Management\EmployeeController@index')
    ->middleware(['auth', 'verified', 'belong.company', 'permission:employee-read'])
    ->name('company.employees');
    
Route::get('/company/{company:slug}/employees/create', 'Management\EmployeeController@create')
    ->middleware(['auth', 'verified', 'belong.company', 'permission:employee-create'])
    ->name('company.employees.create');

Route::get('/company/{company:slug}/buildings', 'Management\BuildingController@index')
    ->middleware(['auth', 'verified', 'belong.company', 'permission:building-read'])
    ->name('company.buildings');

Route::get('/company/{company:slug}/apartments', 'Management\ApartmentController@index')
    ->middleware(['auth', 'verified', 'belong.company', 'permission:apartment-read'])
    ->name('company.apartments');
Route::get('/company/{company:slug}/furnitures', 'Management\FurnitureController@index')
    ->middleware(['auth','verified', 'belong.company', 'permission:furniture-read'])
    ->name('company.furnitures');

Route::get('/company/{company:slug}/furnitures/{furniture}', 'Management\FurnitureController@show')
    ->middleware(['auth','verified','belong.company', 'permission:furniture-read'])
    ->name('company.furnitures.show');
Route::get('/company/{company:slug}/apartment/{apartment}/furnitures', 'Management\ApartmentController@furnitureList')
    ->middleware(['auth','verified', 'belong.company', 'permission:apartment-read'])
    ->name('company.apartment.furnitures');
Route::post('/company/{company:slug}/furnitures/{furniture}/apartment/{apartment}', 'Management\FurnitureController@withdraw')
    ->middleware(['auth','verified', 'belong.company', 'permission:furniture-read'])
    ->name('company.furniture.withdraw');
Route::patch('/company/{id}/furnitures/{furniture}/salvage', 'Management\FurnitureController@salvage')
    ->middleware(['auth','verified', 'permission:furniture-delete'])
    ->name('company.furniture.salvage');
Route::delete('/company/{id}/furnitures/{furniture}', 'Management\FurnitureController@destroy')
    ->middleware(['auth','verified','permission:furniture-delete'])
    ->name('company.furniture.destroy');
/*
Route::get('send', 'NotifyController@index');

Route::get(
    'mail', function () {
        $user = User::find(1);

        return (new App\Notifications\UserUpdate(['email','password']))
                ->toMail($user);
    }
);
*/