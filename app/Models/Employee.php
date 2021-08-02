<?php
/**
 * Employee Model
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
 *  Extended Model
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
        'name', 'birthdate', 'gender', 'nas'
    ];

    protected $appends = [
        'image'
    ];

    /**
     * Get Image Attribute
     *
     * @return void
     */
    public function getImageAttribute()
    {
        return DB::table('users')
            ->join('employee_contracts', 'employee_contracts.user_id', 'users.id')
            ->where('employee_contracts.employee_id', $this->id)
            ->latest('employee_contracts.created_at')
            ->value('users.image');

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
            ->orWhere('employees.gender', 'like', '%'.$query.'%')
            ->orWhere('roles.display_name', 'like', '%'.$query.'%');
    }

    /**
     * Searche for Real State/clients information
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function company()
    {
        return $this->belongsToMany(RealState::class, EmployeeContract::class)
            ->withPivot(
                [
                    'user_id',
                    'start_date',
                    'end_date',
                    'agreement',
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

    /**
     * SetGenderAttribute
     *
     * @param mixed $value value
     *
     * @return void
     */
    public function setGenderAttribute($value)
    {
        switch ($value) {
        case "M":
            $this->attributes['gender'] = "male";
            break;
        case "F":
            $this->attributes['gender'] = "female";
            break;
        case "O":
            $this->attributes['gender'] = "other";
            break;
        default:
            $this->attributes['gender'] = "indefined";
            break;
        }
    }

}
