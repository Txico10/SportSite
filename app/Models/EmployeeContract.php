<?php
/** 
 * Employee Contract pivot model
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

use Illuminate\Database\Eloquent\Relations\Pivot;
/**
 *  Employee Contact Extended Pivot
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeeContract extends Pivot
{
    protected $table = 'employee_contracts';
        
    /**
     * User access through pivot
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * My Company access through pivot
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function myCompany()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
}
