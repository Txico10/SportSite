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
use Illuminate\Support\Facades\DB;
/**
 *  Furniture Extended Model
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
        'real_state_id','furniture_type_id','manufacturer', 
        'model', 'serial', 'buy_at', 'salvage_at', 'qrcode',
    ];
    
    /**
     * Realstate
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function realstate()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
        
    /**
     * FurnitureType
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function furnitureType()
    {
        return $this->belongsTo(FurnitureType::class, 'furniture_type_id');
    }
    
    /**
     * Apartments
     *
     * @return Illuminate\Database\Eloquent\Model 
     */
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, FurnitureApartment::class)
            ->withPivot('id', 'assigned_at', 'withdraw_at')
            ->withTimestamps();
    }
    
    /**
     * Furniture Last assignement
     * 
     * @return Illuminate\Support\Facades\DB
     */
    public function furnitureAssigned()
    {
        return DB::table('furniture_apartment')
            ->where('furniture_id', $this->id)
            ->where('withdraw_at', null)
            ->first();
    }
    
    /**
     * Furniture Unassigned
     *
     * @return void
     */
    public function furnitureUnassigned()
    {
        return DB::table('furniture_apartment')
            ->where('furniture_id', $this->id)
            ->orderByDesc('assigned_at')
            ->value('withdraw_at');
    }
    
    /**
     * Logs
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
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
