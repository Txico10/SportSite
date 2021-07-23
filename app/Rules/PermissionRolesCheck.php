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
    public $roles;
    
    
    /**
     * Create a new rule instance.
     *
     * @param $roles User role
     * 
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
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
        if (!empty($value) && !empty($this->roles)) {
            foreach ($this->roles as $key => $myrole) {
                $role = Role::findOrFail($myrole);
                $validation = $role->permissions->whereIn('id', $value);
                if (count($validation)>0) {
                    return false;
                }
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
