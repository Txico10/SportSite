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

use Illuminate\Database\Eloquent\Model;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Apartment extends Model
{
    protected $fillable = [
        'number', 'description', 'apartment_type_id', 'building_id'
    ];

    /**
     * Building relationship
     * 
     * @return belongTo relationship
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Apartment type relationship
     * 
     * @return belongTo relationship
     */
    public function apartmentType()
    {
        return $this->belongsTo(ApartmentType::class, 'apartment_type_id', 'id');
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query
     * @param mixed                                 $id    Type
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBuilding($query, $id)
    {
        return $query->where('building_id', $id);
    }

    /**
     * Search query
     * 
     * @param $query the query
     * 
     * @return hasMany relationship
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('number', 'like', '%'.$query.'%');
    }
}
