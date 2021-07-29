<?php
/**
 * Laravel Users
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

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laratrust\Traits\LaratrustUserTrait;

/**
 *  Users class
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'active_company'
    ];

    /**
     * Get Active Company Attribute
     *
     * @return int||null
     */
    public function getActiveCompanyAttribute()
    {
        return DB::table('employee_contracts')
            ->where('user_id', $this->id)
            ->whereDate('start_date', '<=', now())
            ->where(
                function ($query) {
                    $query->whereNull('end_date')
                        ->orWhereDate('end_date', '>=', now());
                }
            )
            ->value('real_state_id');
    }

    /**
     * Scope With Last Login Date
     *
     * @param mixed $query Query
     *
     * @return void
     */
    public function scopeWithLastLoginDate($query)
    {
        $query->addSelect(
            ['last_login_at' => Logins::select('created_at')
                ->whereColumn('user_id', 'users.id')
                ->latest()
                ->take(1)
            ]
        )->withCasts(['last_login_at' => 'datetime']);
    }

    /**
     * Render the livewire users view
     *
     * @return $photo URL
     */
    public function adminlte_image()
    {
        $photo = Auth::user()->image;

        if (empty($photo)) {
            $photo = 'https://picsum.photos/300/300';

        } else {
            $photo = asset(Storage::url('profile_images/'.$photo));
        }
        return $photo;
    }

    /**
     * Render the livewire users view
     *
     * @return $photo URL
     */
    public function adminlte_desc()
    {
        return 'That\'s a nice guy';
    }

    /**
     * Render the livewire users view
     *
     * @return profile URL
     */
    public function adminlte_profile_url()
    {
        return route('user.profile', ['user'=>$this]);
    }

    /**
     * Render the livewire users view
     *
     * @param $query receive query format
     *
     * @return query
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
    }

    /**
     * Logins
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function logins()
    {
        return $this->hasMany(Logins::class);
    }

    /**
     * Render the livewire users view
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function contact()
    {

        return $this->morphOne(Contact::class, 'contactable');
    }

    /**
     * Employees
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, EmployeeContract::class)
            ->withPivot(
                [
                    'real_state_id',
                    'status',
                    'start_date',
                    'end_date',
                ]
            )
            ->withTimestamps();
    }

    /**
     * Companies
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function companies()
    {
        return $this->belongsToMany(RealState::class, EmployeeContract::class)
            ->withPivot(
                [
                    'employee_id',
                    'start_date',
                    'end_date',
                    'status',
                ]
            )
            ->withTimestamps();
    }

}
