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
use Illuminate\Support\Facades\DB;

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
        'name', 'neq', 'legalform', 'logo', 'slug'
    ];

    /**
     * Team
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function team()
    {
        return $this->hasOne(Team::class, 'name', 'id');
    }

    /**
     * Buildings relationship
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    /**
     * Apartments relationship
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function apartments()
    {
        return $this->hasManyThrough(Apartment::class, Building::class);
    }

    /**
     * Apartment Types
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function apartmentTypes()
    {
        return $this->hasMany(ApartmentType::class);
    }
    /**
     * Contact relationship
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    /**
     * Furniture Types
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function furnitureTypes()
    {
        return $this->hasMany(FurnitureType::class);
    }
    /**
     * Furnitures
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function furnitures()
    {
        return $this->hasManyThrough(Furniture::class, FurnitureType::class);
    }

    /**
     * Contract Types
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function contractTypes()
    {
        return $this->hasMany(ContractType::class);
    }

    /**
     * Searche for Real State/clients information
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, EmployeeContract::class)
            ->withPivot(['user_id', 'role_id','start_date', 'end_date', 'agreement' ,'status'])
            ->withTimestamps();
    }

    /**
     * Users
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function users()
    {
        return $this->belongsToMany(User::class, EmployeeContract::class)
            //->wherePivot('start_date', '<=', now())
            ->wherePivotNull('end_date')
            ->orWherePivot('end_date', '>=', now())
            ->withTimestamps();
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

}
