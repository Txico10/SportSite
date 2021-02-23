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
    public $allRoles;
    /**
     * Create a new rule instance.
     *
     * @param $roles list of roles
     * 
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
        if ($this->roles) {
            $this->allRoles = Role::all();
        }
        
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
        if ($this->roles) {
            foreach ($this->roles as $key => $roleID) {
                $role = $this->allRoles->find($roleID);
                $permissions = $role->permissions;
                foreach ($permissions as $permission) {
                    for ($i=0; $i < count($value); $i++) {
                        if ($permission->id == $value[$i]) {
                            return false;
                        }
                    }
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
        return 'The :attribute already exists in Role.';
    }
}
