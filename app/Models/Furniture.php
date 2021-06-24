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
        'real_state_id','furniture_type_id','manufacturer', 'model', 'serial', 'buy_at', 'salvage_at', 'qrcode',
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
    
    /**
     * Apartments
     *
     * @return void
     */
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'furniture_apartment', 'furniture_id', 'apartment_id')
            ->withPivot('assigned_at', 'withdraw_at')
            ->withTimestamps();
    }

    /**
     * Set Manufacturer Attribute
     *
     * @param mixed $value Value
     * 
     * @return void
     */
    public function setManufacturerAttribute($value)
    {
        $this->attributes['manufacturer'] = strtolower($value);        
    }
    
    /**
     * Set Model Attribute
     *
     * @param mixed $value Value
     * 
     * @return void
     */
    public function setModelAttribute($value)
    {
        $this->attributes['model'] = strtolower($value);        
    }
    
    /**
     * Set Serial Attribute
     *
     * @param mixed $value Value
     * 
     * @return void
     */
    public function setSerialAttribute($value)
    {
        $this->attributes['serial'] = strtolower($value);
    }
}
