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
        'type', 'description',
    ];
    
    /**
     * Furniture
     *
     * @return void
     */
    public function furniture()
    {
        return $this->hasMany(Furniture::class);
    }
}
