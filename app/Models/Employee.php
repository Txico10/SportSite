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
class Employee extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birthdate', 'gender', 'image'
    ];

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
            : static::where('employees.name', 'like', '%'.$query.'%')
            ->orWhere('employees.birthdate', 'like', '%'.$query.'%')
            ->orWhere('employees.nas', 'like', '%'.$query.'%')
            ->orWhere('employees.gender', 'like', '%'.$query.'%')
            ->orWhere('roles.display_name', 'like', '%'.$query.'%');
    }

    /**
     * Searche for Real State/clients information
     * 
     * @return belongsToMany relationship with pivot
     */
    public function company()
    {
        return $this->belongsToMany(RealState::class, EmployeeContract::class)
            ->withPivot(
                [
                    'user_id',
                    'start_date',
                    'end_date',
                    'status'
                ]
            )
            //->as('contract')
            ->withTimestamps();
    }

    /**
     * Local scope Company
     * 
     * @param $query The query
     * @param $id    Company ID
     * 
     * @return company filter
     */
    public function scopeOfCompany($query, $id)
    {
        return $query->join(
            'employee_contracts',
            'employees.id', 
            'employee_contracts.employee_id',
        )
            ->where('employee_contracts.real_state_id', '=', $id);
    }

    /**
     * Local scope Company
     * 
     * @param $query The query
     * 
     * @return company filter
     */
    public function scopeOfUserRole($query)
    {
        return $query->join(
            'role_user',
            'employee_contracts.user_id',
            'role_user.user_id'
        );
    }

    /**
     * Local scope role
     * 
     * @param $query The query
     * 
     * @return company filter
     */
    public function scopeOfRole($query)
    {
        return $query->join(
            'roles',
            'role_user.role_id',
            'roles.id'
        )
            ->select('employees.*', 'roles.display_name');
    }

}
