<?php
/**
 * Contract types Model
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
 *  Contract  types Extend Model Classe
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ContractType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['real_state_id','name', 'tag' ,'description'];

    /**
     * Company of apartment settings
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function company()
    {
        return $this->belongsTo(RealState::class);
    }
}
