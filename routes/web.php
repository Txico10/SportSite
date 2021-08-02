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

/**
 * Admin User Management
 */
Route::get('/users/{user:id}/profile', 'User\UserController@profile')
    ->middleware(['auth', 'verified'])->name('user.profile');
Route::patch('/admin/users/{id}/changeStatus', 'User\UserController@changeStatus')
    ->middleware(['auth', 'verified', 'role:superadministrator|administrator'])
    ->name('users.changeStatus');

Route::middleware(['auth', 'verified'])->name('users.')->prefix('/admin/users/{user}')
    ->group(
        function () {
            Route::post('/permissions', 'User\UserController@getPermissions')
                ->middleware('role:superadministrator|administrator')
                ->name('permissions.list');
            Route::post('/roles', 'User\UserController@getRoles')
                ->middleware('role:superadministrator|administrator')
                ->name('roles.list');
            Route::post('/fillroleprofiles', 'User\UserController@fillRolesProfiles')
                ->middleware('role:superadministrator|administrator')
                ->name('rolesprofiles.fill');
            Route::patch('/update-roles-permissions', 'User\UserController@updateRolesPermissions')
                ->middleware('role:superadministrator|administrator')
                ->name('rolesprofiles.update');
        }
    );

/**
 * Apartment Settings and Furniture Settings
 */
Route::middleware(['auth', 'verified','role:superadministrator|administrator'])
    ->name('company.')->prefix('/company/{company:slug}')->group(
        function () {
            //apartment-setting
            Route::get('/apartments-setting', 'Management\ApartmentTypeController@index')
                ->name('apartment-setting');
            Route::post('/apartments-setting', 'Management\ApartmentTypeController@store')
                ->name('apartment-setting.store');
            Route::post('/apartments-setting/edit', 'Management\ApartmentTypeController@edit')
                ->name('apartment-setting.edit');
            Route::delete('/apartments-setting/destroy', 'Management\ApartmentTypeController@destroy')
                ->name('apartment-setting.destroy');
            //furniture-setting
            Route::get('/furnitures-setting', 'Management\FurnitureTypeController@index')
                ->name('furniture-setting');
            Route::post('/furniture-setting', 'Management\FurnitureTypeController@store')
                ->name('furniture-setting.store');
            Route::post('/furnitures-setting/edit', 'Management\FurnitureTypeController@edit')
                ->name('furniture-setting.edit');
            Route::delete('/furnitures-setting/destroy', 'Management\FurnitureTypeController@destroy')
                ->name('furniture-setting.destroy');
            //contract-settings
            Route::get('/contract-setting', 'Management\ContractTypeController@index')
                ->name('contract-setting');
        }
    );
/**
 * Company
 */
Route::middleware(['auth', 'verified', 'belong.company'])
    ->name('company.')->prefix('/company/{company:slug}')->group(
        function () {
            //Company profile
            Route::get('/profile', 'Management\RealStateController@profile')
                ->middleware('permission:company-read')
                ->name('profile');
            //Employees CRUD
            Route::get('/employees', 'Management\EmployeeController@index')
                ->middleware('permission:employee-read')
                ->name('employees');
            Route::get('/employees/create', 'Management\EmployeeController@create')
                ->middleware('permission:employee-create')
                ->name('employees.create');
            Route::get('/employees/{employee}', 'Management\EmployeeController@show')
                ->middleware('permission:employee-read')
                ->name('employees.show');
            //Building CRUD
            Route::get('/buildings', 'Management\BuildingController@index')
                ->middleware('permission:building-read')
                ->name('buildings');
            //Apartments CRUD
            Route::get('/apartments', 'Management\ApartmentController@index')
                ->middleware('permission:apartment-read')
                ->name('apartments');
            //Furnitures CRUD
            Route::get('/furnitures', 'Management\FurnitureController@index')
                ->middleware('permission:furniture-read')
                ->name('furnitures');
            Route::get('/furnitures/{furniture}', 'Management\FurnitureController@show')
                ->middleware('permission:furniture-read')
                ->name('furnitures.show');
            //Apartments furnitures
            //READ
            Route::get('/apartment/{apartment}/furnitures', 'Management\ApartmentController@furnitureList')
                ->middleware('permission:apartment-read')
                ->name('apartment.furnitures');
            //withdraw
            Route::post('/furnitures/{furniture}/apartment/{apartment}', 'Management\FurnitureController@withdraw')
                ->middleware('permission:furniture-read')
                ->name('furniture.withdraw');
            //Salvage
            Route::patch('/furnitures/{furniture}/salvage', 'Management\FurnitureController@salvage')
                ->middleware('permission:furniture-delete')
                ->name('furniture.salvage');
            //Delete
            Route::delete('/furnitures/{furniture}', 'Management\FurnitureController@destroy')
                ->middleware('permission:furniture-delete')
                ->name('furniture.destroy');
        }
    );

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
