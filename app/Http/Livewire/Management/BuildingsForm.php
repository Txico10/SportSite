<?php
/** 
 * Building Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Http\Livewire\Management;

use Livewire\Component;
/**
 *  Livewire building form component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class BuildingsForm extends Component
{
    public $building_id;

        
    /**
     * Mount
     *
     * @param mixed $id the id of the building if existes
     * 
     * @return void
     */
    public function mount($id = null)
    {
        $this->building_id = $id;
    }
        
    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.management.buildings-form');
    }

}
