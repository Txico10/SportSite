<?php
/** 
 * Custom password check rule
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

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

/**
 *  CustomPasswordCheck class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class CustomPasswordCheck implements Rule
{
    public $hashedPassword;
    /**
     * Create a new rule instance.
     * 
     * @param $hashedPassword the hashed password
     *
     * @return void
     */
    public function __construct($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute the attribute
     * @param mixed  $value     the value
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Hash::check($value, $this->hashedPassword)) {
                    
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The current password is not correct. Please try again.';
    }
}
