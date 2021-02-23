<?php
/** 
 * Laratrust Roles Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Models;

use Laratrust\Models\LaratrustPermission;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Permission extends LaratrustPermission
{
    public $guarded = [];

    /**
     * Search form permissions
     * 
     * @param $query 
     * 
     * @return livewire_permissions
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('display_name', 'like', '%'.$query.'%')
            ->orWhere('name', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%');
    }
}
