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
    public $building;
    public $lot;
    public $description;

    protected $listeners = [
        'editBuilding' => 'edit', 
        'editBuildingContact' => 'editContact'
    ];

        
    /**
     * Render
     *
     * @return view building-form
     */
    public function render()
    {
        //dd($this->building_id);
        return view('livewire.management.buildings-form');
    }

        
    /**
     * Edit
     * 
     * @return void
     */
    public function edit($building)
    {
        dd($building);
        $this->dispatchBrowserEvent('openBuildingModal');
    }
    
    /**
     * EditContact
     *
     * @param mixed $contact building contact
     * 
     * @return void
     */
    public function editContact($contact)
    {
        dd($contact);
    }

}
