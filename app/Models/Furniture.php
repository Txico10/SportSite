<?php
/** 
 * Furniture model
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
 *  Extended Model
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Furniture extends Model
{
    protected $fillable = [
        'manufacturer', 'model', 'serial', 'buy_at', 'salvage_at', 'qrcode'
    ];
    
    /**
     * Realstate
     *
     * @return void
     */
    public function realstate()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
        
    /**
     * FurnitureType
     *
     * @return void
     */
    public function furnitureType()
    {
        return $this->belongsTo(FurnitureType::class, 'furniture_type_id');
    }
}
