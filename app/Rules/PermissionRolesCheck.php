<?php
/** 
 * Livewire User Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Rules;

use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;
/**
 *  Livewire Users component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class PermissionRolesCheck implements Rule
{
    public $role;
    
    
    /**
     * Create a new rule instance.
     *
     * @param $role User role
     * 
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute the attribute
     * @param mixed  $value     the value to be compared
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //dd($value);
        if ($value->count()>0 && !empty($this->role)) {
            $role = Role::where('id', $this->role)->first();
            $validate = $role->permissions->whereIn('id', $value);
            if (!empty($validate)) {
                return false;
            }

        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The permission already exists in Role.';
    }
}
