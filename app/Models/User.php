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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
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

    /**
     * Render the livewire users view
     * 
     * @return $photo URL
     */
    public function adminlte_image() 
    {
        $photo = auth()->user()->image;
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
        return url("/users/".Auth::id()."/profile");
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
     * Render the livewire users view
     * 
     * @return morphMany relationship
     */
    public function contacts() 
    {

        return $this->morphMany(Contact::class, 'contactable');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, EmployeeContract::class)
            ->withPivot(
                [
                    'real_state_id',
                    'start_date',
                    'end_date',
                ]
            )
            ->withTimestamps();
    }

}
