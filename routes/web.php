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
            Route::namespace('Admin')->group(
                function () {
                    Route::get('/roles', 'RoleController@index')
                        ->name('role');
                }
            );
            Route::get('/clients', 'Management\RealStateController@index')
            ->name('clients');
        }
    );

Route::get('/company/{id}/profile', 'Management\RealStateController@profile')
    ->middleware(['auth', 'verified', 'permission:company-read'])
    ->name('company.profile');

Route::get('/users/{id}/profile', 'User\UserController@profile')
    ->middleware(['auth', 'verified'])->name('user.profile');
    
Route::get('/company/{id}/employees', 'Management\EmployeeController@index')
    ->middleware(['auth', 'verified', 'permission:employee-read'])
    ->name('company.employees');
    
Route::get('/company/{id}/employees/create', 'Management\EmployeeController@create')
    ->middleware(['auth', 'verified', 'permission:employee-create'])
    ->name('company.employees.create');

Route::get('/company/{id}/buildings', 'Management\BuildingController@index')
    ->middleware(['auth', 'verified', 'permission:building-read'])
    ->name('company.buildings');

Route::get('/company/{id}/apartments', 'Management\ApartmentController@index')
    ->middleware(['auth', 'verified', 'permission:apartment-read'])
    ->name('company.apartments');
Route::get('/company/{id}/furnitures', 'Management\FurnitureController@index')
    ->middleware(['auth','verified','permission:furniture-read'])
    ->name('company.furnitures');

Route::get('/company/{id}/furnitures/{furniture}', 'Management\FurnitureController@show')
    ->middleware(['auth','verified','permission:furniture-read'])
    ->name('company.furnitures.show');
Route::get('/company/{id}/apartment/{apartment}/furnitures', 'Management\ApartmentController@furnitureList')
    ->middleware(['auth','verified','permission:apartment-read'])
    ->name('company.apartment.furnitures');
Route::post('/company/{id}/furnitures/{furniture}/apartment/{apartment}', 'Management\FurnitureController@withdraw')
    ->middleware(['auth','verified','permission:furniture-read'])
    ->name('company.furniture.withdraw');
Route::patch('/company/{id}/furnitures/{furniture}/salvage', 'Management\FurnitureController@salvage')
    ->middleware(['auth','verified','permission:furniture-delete'])
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