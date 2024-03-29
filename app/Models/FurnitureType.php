<?php
/**
 * Furniture Type Model
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

use Illuminate\Database\Eloquent\Model;
/**
 *  Extended Furniture Type Model
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnitureType extends Model
{
    protected $fillable = [
        'real_state_id','type', 'description',
    ];

    /**
     * Furniture
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function furnitures()
    {
        return $this->hasMany(Furniture::class);
    }

    /**
     * Company
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function company()
    {
        return $this->belongsTo(RealState::class);
    }
}
