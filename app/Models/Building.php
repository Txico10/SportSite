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
class Building extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lot', 'alias' ,'description'];
    
    /**
     * RealState relationship
     * 
     * @return belongTo relationship
     */
    public function realstate()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
    /**
     * Contact relationship
     * 
     * @return morphOne relationship
     */
    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    /**
     * Apartments relationship
     * 
     * @return hasMany relationship
     */
    public function apartments()
    {
        return $this->hasMany(Apartment::class);
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
            : static::where('lot', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%');
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query
     * @param mixed                                 $id    Type
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCompany($query, $id)
    {
        return $query->where('real_state_id', $id);
    }
}
