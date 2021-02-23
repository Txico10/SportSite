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

class BuildingsForm extends Component
{
    public $building_id;

    public function mount($id)
    {
        $this->building_id = $id;
    }
    public function render()
    {
        return view('livewire.management.buildings-form');
    }
}
