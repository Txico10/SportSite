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
class ApartmentType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['real_state_id','name', 'tag' ,'description'];
    
    /**
     * Apartments
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
    
    /**
     * Company of apartment settings 
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function company()
    {
        return $this->belongsTo(RealState::class);
    }
    
    /**
     * GetFullNameAttribute
     *
     * @return string full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->tag} {$this->_decodeMyCode('&#8658;')} {$this->name}";
    }
    
    /**
     * _decodeMyCode
     *
     * @param mixed $code encoded
     * 
     * @return $newCode decoded
     */
    private function _decodeMyCode($code)
    {
        
        $newCode = html_entity_decode($code, ENT_QUOTES);

        return $newCode;
    }
}
