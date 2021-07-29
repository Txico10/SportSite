<?php
/**
 * Laratrust Team Model
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

use Laratrust\Models\LaratrustTeam;
use Illuminate\Support\Facades\Config;

/**
 *  Team extend Laratrust Team Classe
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Team extends LaratrustTeam
{
    public $guarded = [];

    /**
     * Team users
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * Company
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function company()
    {
        return $this->hasOne(RealState::class, 'id', 'name');
    }




}
