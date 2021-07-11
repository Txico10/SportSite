<?php
/** 
 * Furniture assignement date rule
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
/**
 *  Furniture assignement rule
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnitureAssignDate implements Rule
{
    private $_withdraw;

    /**
     * Create a new rule instance.
     * 
     * @param $withdraw Withdraw date
     * 
     * @return void
     */
    public function __construct($withdraw)
    {
        $this->_withdraw = $withdraw;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute attribute
     * @param mixed  $value     value
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->_withdraw!=null && $this->_withdraw>$value) {
            return false;
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
        return 'The selectd date cant be smaller than the last withdraw date.';
    }
}
