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
class RealState extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'neq', 'legalform', 'logo'
    ];
    
    /**
     * Buildings relationship
     * 
     * @return hasMany relationship
     */
    public function buildings()
    {
        return $this->hasMany(Building::class);
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
     * Searche for Real State/clients information
     * 
     * @param $query receive query format
     * 
     * @return query
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%');
                //->orWhere('email', 'like', '%'.$query.'%');
    }

    /**
     * Searche for Real State/clients information
     * 
     * @return query
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, EmployeeContract::class)
            ->withPivot(
                [
                    'start_date',
                    'end_date',
                    'status'
                ]
            )
            ->withTimestamps();
    }
}
