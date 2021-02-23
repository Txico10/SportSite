<?php
/** 
 * App service provider
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
/**
 *  AppServiceProvider Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dispatcher $events listening event
     * 
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //Database settings
        Schema::defaultStringLength(191);
            
        // Menu bilder
        $events->listen(
            BuildingMenu::class, function (BuildingMenu $event) {
                // Add some items to the menu...
                $company = DB::table('employee_contracts')
                    ->where('user_id', auth()->user()->id)
                    ->select('real_state_id')->get();
                
                $event->menu->addBefore(
                    'role', 
                    [
                        'key' => 'user',
                        'text' => 'Users',
                        'route'  => 'admin.users',
                        'icon' => 'fas fa-fw fa-users',
                        'permission' => 'users-read',
                        'label' => User::count(),
                        'label_color' => 'success',
                    ]
                );
                $event->menu->addAfter(
                    'role', 
                    [
                        'key' => 'enterprises',
                        'text' => 'Clients',
                        'route'  => 'admin.clients',
                        'icon' => 'fas fa-fw fa-list',
                        'permission' => 'company-read',
                    ]
                );
                $event->menu->add(
                    [
                        'header' => 'REAL STATE MANAGEMENT', 'permission' => 'companyMenu-read',
                    ]
                );
                if (!empty($company[0])) {
                    $event->menu->add(
                        [
                            'key' => 'real_state',
                            'text' => 'Real State',
                            'route'  => ['company.profile',["id" => $company[0]->real_state_id]],
                            'icon' => 'fas fa-fw fa-info',
                            'permission' => 'company-read',
                        ],
                    );
                    
                    $event->menu->add(
                        [
                            'key' => 'buildings',
                            'text' => 'Buildings',
                            'route'  => ['company.buildings', ["id" => $company[0]->real_state_id]],
                            'icon' => 'fas fa-fw fa-building',
                            'permission' => 'building-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'apartments',
                            'text' => 'Apartments',
                            'route'  => ['company.apartments', ["id" => $company[0]->real_state_id]],
                            'icon' => 'fas fa-fw fa-home',
                            'permission' => 'apartment-read',
                        ],
                    );
                    $event->menu->add(
                        [
                            'key' => 'furnitures',
                            'text' => 'Furnitures',
                            'url'  => '#',
                            'icon' => 'fas fa-fw fa-chair',
                            'permission' => 'furniture-read',
                        ],
                    );
                }
            }
        );
    }
}
