<?php
/** 
 * Laratrust Roles Component
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
 *  Extended Laratrust Roles Classe
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
        'suite','num','street','city','region','country','pc','telephone','mobile', 'name', 'type', 'relationship', 'email',
    ];
    
    /**
     * Render the livewire users view
     * 
     * @return morphTo relationship
     */
    public function contactable() 
    {
        return $this->morphTo();
    }
}
