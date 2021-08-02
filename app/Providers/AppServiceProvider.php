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

use App\Models\RealState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Laratrust\LaratrustFacade;

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

                if (LaratrustFacade::hasRole(['superadministrator','administrator'])) {

                    $event->menu->add(
                        [
                            'header' => 'ADMINISTRATION',
                            'permission' => 'adminMenu-read'
                        ]
                    );
                    $event->menu->add(
                        [
                            'key' => 'role',
                            'text' => 'Roles',
                            'route'  => 'admin.role',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'permission' => 'roles-read',
                        ],
                    );
                    $event->menu->addBefore(
                        'role',
                        [
                            'key' => 'user',
                            'text' => 'Users',
                            'route'  => 'admin.users',
                            'icon' => 'fas fa-fw fa-users',
                            'permission' => 'users-read',
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
                            'permission' => 'allCompanies-read',
                        ]
                    );
                }


                if (LaratrustFacade::hasRole(['administrator', 'manager', 'janitor'])) {

                    $companyID = Auth::user()->active_company;

                    if (!empty($companyID)) {

                        $company = RealState::findOrFail($companyID);

                        $event->menu->addAfter(
                            'role',
                            [
                                'key' => 'configurations',
                                'text' => 'Settings',
                                'icon' => 'fas fa-fw fa-cogs',
                                'permission' => 'confugurationMenu-read',
                                'submenu' => [
                                    [
                                        'key' => 'apartmentType',
                                        'text' => 'Apartments',
                                        'route'  => ['company.apartment-setting', ['company' => $company]],
                                        'icon' => 'fas fa-fw fa-home',
                                    ],
                                    [
                                        'key' => 'contractType',
                                        'text' => 'Contracts',
                                        'route'  => ['company.contract-setting', ['company' => $company]],
                                        'icon' => 'fas fa-fw fa-file-contract',
                                    ],
                                    [
                                        'key' => 'furnitureConfig',
                                        'text' => 'Appliances & Furniture',
                                        'route'  => ['company.furniture-setting', ['company' => $company]],
                                        'icon' => 'fas fa-fw fa-couch',
                                    ],
                                ],
                            ]
                        );

                        $event->menu->add(
                            [
                                'header' => 'COMPANY MANAGEMENT',
                                'permission' => 'companyMenu-read',
                            ]
                        );
                        $event->menu->add(
                            [
                                'key' => 'real_state',
                                'text' => 'My Company',
                                'route'  => ['company.profile',['company' => $company]],
                                'icon' => 'fas fa-fw fa-info',
                                'permission' => 'company-read',
                            ],
                        );
                        $event->menu->add(
                            [
                                'key' => 'employees',
                                'text' => 'Employees',
                                'icon' => 'fas fa-fw fa-user-tie',
                                'permission' => 'employee-read',
                                'submenu' => [
                                    [
                                        'text' => 'All Employees',
                                        'route'  => ['company.employees', ['company' => $company]],
                                        'icon' => 'fas fa-fw fa-users',
                                        'permission' => 'employee-read',
                                    ],
                                    [
                                        'text' => 'New Employee',
                                        'route'  => ['company.employees.create', ['company' => $company]],
                                        'icon' => 'fas fa-fw fa-user-plus',
                                        'permission' => 'employee-create',
                                    ],
                                ]
                            ],
                        );
                        $event->menu->add(
                            [
                                'key' => 'buildings',
                                'text' => 'Buildings',
                                'route'  => ['company.buildings', ['company' => $company]],
                                'icon' => 'fas fa-fw fa-building',
                                'permission' => 'building-read',
                            ],
                        );
                        $event->menu->add(
                            [
                                'key' => 'apartments',
                                'text' => 'Apartments',
                                'route'  => ['company.apartments', ['company' => $company]],
                                'icon' => 'fas fa-fw fa-home',
                                'permission' => 'apartment-read',
                            ],
                        );
                        $event->menu->add(
                            [
                                'key' => 'furnitures',
                                'text' => 'Furnitures',
                                'route'  => ['company.furnitures', ['company' => $company]],
                                'icon' => 'fas fa-fw fa-chair',
                                'permission' => 'furniture-read',
                            ],
                        );
                    }
                }


                $event->menu->add(
                    [
                        'header' => 'LEASE MANAGEMENT',
                        'permission' => 'leaseMenu-read'
                    ],
                );
                $event->menu->add(
                    [
                        'key' => 'tenats',
                        'text' => 'Tenants',
                        'url'  => '#',
                        'icon' => 'fas fa-fw fa-users',
                        'permission' => 'tenant-read',
                    ],
                );
                $event->menu->add(
                    [
                        'key' => 'lease',
                        'text' => 'Lease',
                        'url'  => '#',
                        'icon' => 'fas fa-fw fa-file-contract',
                        'permission' => 'lease-read',
                    ],
                );
                $event->menu->add(
                    [
                        'key' => 'payments',
                        'text' => 'Payments',
                        'url'  => '#',
                        'icon' => 'fas fa-fw fa-credit-card',
                        'permission' => 'payment-read',
                    ],
                );
                $event->menu->add(
                    [
                        'header' => 'MAINTENANCE',
                        'permission' => 'manteinanceMenu-read'
                    ],
                );
                $event->menu->add(
                    [
                        'key' => 'tickets',
                        'text' => 'Tickets',
                        'url'  => '#',
                        'icon' => 'fas fa-fw fa-ticket-alt',
                        'permission' => 'ticket-read',
                    ],
                );

            }
        );
    }
}
