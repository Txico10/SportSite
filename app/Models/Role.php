<?php
/** 
 * Laratrust Role Model
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

use Laratrust\Models\LaratrustRole;
/**
 *  Role extend Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Role extends LaratrustRole
{
    public $guarded = [];

    /**
     * Render the livewire users view
     * 
     * @param $query 
     * 
     * @return livewire_roles
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('display_name', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%');
    }
    
}
