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
namespace App\MenuFilter;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
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
class MyMenuFilter implements FilterInterface
{
    /**
     * Register any application services.
     *
     * @param $item menu item
     * 
     * @return void
     */
    public function transform($item)
    {
        if (isset($item['permission']) && !LaratrustFacade::isAbleTo($item['permission'])) {
            $item['restricted'] = true;
        }

        return $item;
    }
}