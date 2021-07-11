<?php
/** 
 * Contact Model
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
 *  Log Model Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Log extends Model
{
    protected $fillable = ['title', 'description', 'logs_parameter_id', 'user_id', 'occurred_at'];

    /**
     * Logable relationship
     * 
     * @return morphTo relationship
     */
    public function logable() 
    {
        return $this->morphTo();
    }
    
    /**
     * Parameter of log
     *
     * @return void
     */
    public function parameter()
    {
        return $this->belongsTo(LogsParameter::class, 'logs_parameter_id');
    }
    
    /**
     * User who creates de log
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
