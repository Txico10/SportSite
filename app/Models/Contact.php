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
 *  Contact Model Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Contact extends Model
{
    protected $fillable = [
        'suite','num','street','city','region','country','pc','telephone',
        'mobile', 'name', 'type', 'relationship', 'email',
    ];
    
    /**
     * Render the livewire users view
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function contactable() 
    {
        return $this->morphTo();
    }
}
